<?php
# PHPGGC: PHP Generic Gadget Chains
# Library of generic exploitation vectors for unserialize()
#

define('DIR_BASE', realpath(dirname(dirname(__FILE__))));
define('DIR_TEMPLATES', DIR_BASE . '/templates');
define('DIR_LIB', DIR_BASE . '/lib');
define('DIR_GADGETCHAINS', DIR_BASE . '/gadgetchains');


use \PHPGGC\Enhancement;


PHPGGC::autoload_register();
PHPGGC::include_gadget_chains();


/**
 * This class is meant to handle CLI parameters and return a serialized payload
 * under different forms. 
 */
class PHPGGC
{
    protected $chains;

    public function __construct()
    {
        $this->chains = $this->load_gadget_chains();
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
            return;

        if(count($parameters) < 1)
        {
            $this->help();
            return;
        }

        $class = array_shift($parameters);
        $gc = $this->get_gadget_chain($class);

        $this->setup_enhancements();
        $parameters = $this->get_type_parameters($gc, $parameters);
        $generated = $this->serialize($gc, $parameters);

        if(in_array('test-payload', $this->options))
            $this->test_payload($gc, $generated);
        else
            $this->output_payload($generated);
    }

    /**
     * Runs generated payload using the ./template/test_payload.php script.
     * We have to use system() here, because the classes used during the
     * deserialization process are already defined by PHPGGC, and there is no
     * mechanism allowing to delete classes in PHP. Therefore, a new PHP process
     * has to be created.
     */
    public function test_payload($gc, $payload)
    {
        $this->o('Trying to deserialize payload...');
        $vector = isset($this->parameters['phar']) ? 'phar' : $gc::$vector;
        system(
            escapeshellarg(DIR_LIB . '/test_payload.php') . ' ' .
            escapeshellarg($vector) . ' ' .
            escapeshellarg(base64_encode($payload))
        );
    }

    /**
     * Displays the payload or stores it in a file.
     */
    public function output_payload($payload)
    {
        if(!isset($this->parameters['output'])) 
        {
            print($payload);
            if (!isset($this->parameters['phar']))
                print("\n");
        }
        else
        {
            file_put_contents($this->parameters['output'], $payload);
        }
    }

    /**
     * Returns an instance of the given gadget chain.
     */
    public function get_gadget_chain($name)
    {
        $name = strtolower($name);
        if(!array_key_exists($name, $this->chains))
        {
            $this->e('Unknown gadget chain: ' . $name);
        }

        $class = $this->chains[$name];

        if(
            isset($this->parameters['phar']) &&
            $class::$vector != '__destruct' &&
            $class::$vector != '__wakeup'
        )
        {
            $this->e('Phar requires either a __destruct or a __wakeup vector');
        }

        return new $class();
    }
    
    /**
     * Create enhancement instances from given options
     */
    public function setup_enhancements()
    {
        $enhancements = [];

        if(isset($this->parameters['wrapper']))
            $enhancements[] = new Enhancement\Wrapper($this->parameters['wrapper']);
        if(in_array('fast-destruct', $this->options))
            $enhancements[] = new Enhancement\FastDestruct();
        if(in_array('ascii-strings', $this->options))
            $enhancements[] = new Enhancement\ASCIIStrings();
        if(isset($this->parameters['plus-numbers']))
            $enhancements[] = new Enhancement\PlusNumbers(
                $this->parameters['plus-numbers']
            );
        $this->enhancements = new Enhancement\Enhancements($enhancements);
    }

    /**
     * Generates the serialized payload from given gadget and parameters.
     */
    public function serialize($gc, $parameters)
    {
        $parameters = $this->process_parameters($gc, $parameters);
        $object = $gc->generate($parameters);
        $object = $this->process_object($gc, $object);
        $serialized = serialize($object);
        $serialized = $this->process_serialized($gc, $serialized);
        return $serialized;
    }

    /**
     * Includes every file that might contain a gadget chain.
     */
    public static function include_gadget_chains()
    {
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator(DIR_GADGETCHAINS),
            RecursiveIteratorIterator::LEAVES_ONLY
        );
        $regex = '#' . preg_quote(DIRECTORY_SEPARATOR) . 'chain.php$#';
        foreach ($iterator as $filename)
        {
            if(preg_match($regex, $filename))
                include_once $filename;
        }
    }

    /**
     * Loads every available gadget and returns an array of the form
     * class_name => class.
     */
    public function load_gadget_chains()
    {
        $classes = get_declared_classes();
        $classes = array_filter($classes, function($class) {
            return is_subclass_of($class, '\\PHPGGC\\GadgetChain') &&
                   strpos($class, 'GadgetChain\\') === 0;
        });

        # Convert backslashes in classes names to forward slashes,
        # so that the command line is easier to use
        $names = array_map(function($class) {
            return strtolower($class::get_name());
        }, $classes);

        $gcs = array_combine($names, $classes);
        ksort($gcs);

        return $gcs;
    }

    /**
     * Registers PHPGGC's autoload function.
     */
    public static function autoload_register()
    {
        spl_autoload_register(array(static::class, 'autoload'));
    }

    /**
     * Autoloads PHPGGC base classes only, in order to avoid conflict between
     * different gadget chains.
     */
    public static function autoload($class)
    {
        $file = DIR_LIB . '/' . str_replace('\\', '/', $class) . '.php';
        if(file_exists($file))
            require_once $file;
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

        $files = glob(DIR_LIB . '/PHPGGC/GadgetChain/*.php');

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

        $base = DIR_GADGETCHAINS . '/' . $name . '/' . $type . '/';

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
        $base = substr($base, strlen(DIR_BASE) + 1);

        $this->o('Created ' . $full_name . ' under: ' . $base);
    }

    /**
     * Creates a file in directory $path from template $name.
     */
    function create_from_template($path, $name, $replacements=null)
    {
        $template = DIR_TEMPLATES . '/' . $name;
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
        if(ini_get('phar.readonly') == '1')
        {
            $this->e('Cannot create phar: phar.readonly is set to 1');
        }

        $format = $this->parameters['phar'];
        
        $prefix = '';
        $filename = 'test.txt';
        $jpeg = null;

        if(isset($this->parameters['phar-prefix']))
            $prefix = file_get_contents($this->parameters['phar-prefix']);
        if(isset($this->parameters['phar-filename']))
            $filename = $this->parameters['phar-filename'];
        if(isset($this->parameters['phar-jpeg']))
            $jpeg = $this->parameters['phar-jpeg'];

        $class = 'PHPGGC\\Phar\\' . ucfirst($format);

        $phar = new $class($serialized, compact('prefix', 'filename', 'jpeg'));
        return $phar->generate();
    }

    /**
     * Applies command line parameters and options to the gadget chain
     * parameters.
     */
    protected function process_parameters($gc, $parameters)
    {
        $parameters = $this->enhancements->process_parameters($parameters);
        $parameters = $gc->process_parameters($parameters);
        return $parameters;
    }

    /**
     * Applies command line parameters and options to the gadget chain object.
     */
    protected function process_object($gc, $object)
    {
        $object = $gc->process_object($object);
        $object = $this->enhancements->process_object($object);
        return $object;
    }

    /**
     * Applies command line parameters and options to the serialized payload.
     */
    protected function process_serialized($gc, $serialized)
    {
        $serialized = $gc->process_serialized($serialized);
        $serialized = $this->enhancements->process_serialized($serialized);

        # Phar
        if(isset($this->parameters['phar']))
            $serialized = $this->phar_generate($serialized);

        # Encoding
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
                    $keys = str_split("%\x00\n\r\t+;");
                    $values = array_map('urlencode', $keys);
                    $serialized = str_replace($keys, $values, $serialized);
                    break;
                case 'json':
                    $serialized = json_encode($serialized);
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

    protected function e($message)
    {
        throw new PHPGGC\Exception($message);
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

    /**
     * Displays a list of gadget chains.
     */
    protected function list_gc($filter)
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
            if($filter && stripos($chain::get_name(), $filter) === false)
                continue;
            $data[] = [
                $chain::get_name(),
                $chain::$version,
                $chain::$type,
                $chain::$vector,
                ($chain::$information ? '*' : '')
            ];
        }

        $this->o($this->table($titles, $data));

        exit(0);
    }

    /**
     * Displays the help.
     */
    protected function help()
    {
        $this->o('');
        $this->o('PHPGGC: PHP Generic Gadget Chains');
        $this->o("---------------------------------", 2);

        $this->o('USAGE');
        $this->o("  " . $this->_get_command_line(
            '[-h|-l|-i|...]',
            '<GadgetChain>',
            '[arguments]'
        ), 2);

        $this->o('INFORMATION');
        $this->o('  -h, --help Displays help');
        $this->o('  -l, --list [filter] Lists available gadget chains');
        $this->o('  -i, --information');
        $this->o('     Displays information about a gadget chain');
        $this->o('');
        $this->o('OUTPUT');
        $this->o('  -o, --output <file>');
        $this->o('     Outputs the payload to a file instead of standard output');
        $this->o('');
        $this->o('PHAR');
        $this->o('  -p, --phar <tar|zip|phar>');
        $this->o('     Creates a PHAR file of the given format');
        $this->o('  -pj, --phar-jpeg <file>');
        $this->o('     Creates a polyglot JPEG/PHAR file from given image');
        $this->o('  -pp, --phar-prefix <file>');
        $this->o('     Sets the PHAR prefix as the contents of the given file.');
        $this->o('     Generally used with -p phar to control the beginning of the generated file.');
        $this->o('  -pf, --phar-filename <filename>');
        $this->o('     Defines the name of the file contained in the generated PHAR (default: test.txt)');
        $this->o('');
        $this->o('ENHANCEMENTS');
        $this->o('  -f, --fast-destruct');
        $this->o('     Applies the fast-destruct technique, so that the object is destroyed');
        $this->o('     right after the unserialize() call, as opposed to at the end of the');
        $this->o('     script');
        $this->o('  -a, --ascii-strings');
        $this->o('     Uses the \'S\' serialization format instead of the standard \'s\'. This');
        $this->o('     replaces every non-ASCII value to an hexadecimal representation:');
        $this->o('     s:5:"A<null_byte>B<cr><lf>"; -> S:5:"A\\00B\\09\\0D";');
        $this->o('     This is experimental and it might not work in some cases.');
        $this->o('  -n, --plus-numbers <types>');
        $this->o('     Adds a + symbol in front of every number symbol of the given type.');
        $this->o('     For instance, -n iO adds a + in front of every int and object name size:');
        $this->o('     O:3:"Abc":1:{s:1:"x";i:3;} -> O:+3:"Abc":1:{s:1:"x";i:+3;}');
        $this->o('     Note: Since PHP 7.2, only i and d (float) types can have a +');
        $this->o('  -w, --wrapper <wrapper>');
        $this->o('     Specifies a file containing either or both functions:');
        $this->o('       - process_parameters($parameters): called right before object is created');
        $this->o('       - process_object($object): called right before the payload is serialized');
        $this->o('       - process_serialized($serialized): called right after the payload is serialized');
        $this->o('');
        $this->o('ENCODING');
        $this->o('  -s, --soft   Soft URLencode');
        $this->o('  -u, --url    URLencodes the payload');
        $this->o('  -b, --base64 Converts the output into base64');
        $this->o('  -j, --json   Converts the output into json');
        $this->o('  Encoders can be chained, for instance -b -u -u base64s the payload,');
        $this->o('  then URLencodes it twice');
        $this->o('');
        $this->o('CREATION');
        $this->o('  -N, --new <framework> <type>');
        $this->o('    Creates the file structure for a new gadgetchain for given framework');
        $this->o('    Example: ./phpggc -n Drupal RCE');
        $this->o('  --test-payload');
        $this->o('    Instead of displaying or storing the payload, includes vendor/autoload.php and unserializes the payload.');
        $this->o('    The test script can only deserialize __destruct, __wakeup, __toString and PHAR payloads.');
        $this->o('    Warning: This will run the payload on YOUR system !');
        $this->o('');

        $this->o('EXAMPLES');
        $this->o('  ' . $this->_get_command_line(
            '-l'
        ));
        $this->o('  ' . $this->_get_command_line(
            '-l drupal'
        ));
        $this->o('  ' . $this->_get_command_line(
            'Laravel/RCE1',
            'system',
            'id'
        ));
        $this->o('  ' . $this->_get_command_line(
            'SwiftMailer/FW1',
            '/var/www/html/shell.php',
            '/path/to/local/shell.php'
        ));
        $this->o('');

        exit(0);
    }

    /**
     * Parses argument $i of $argv, and stores it in parameters or options if
     * it matches.
     */
    function _parse_cmdline_arg(&$i, &$argv, &$parameters, &$options)
    {
        $count = count($argv);

        # Define valid arguments and their abbreviations, which is generally
        # their first letter

        $valid_arguments = [
            # Creation
            'new' => false,
            'test-payload' => false,
            # Misc
            'informations' => false,
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
            'plus-numbers' => true,
            # Encoders
            'soft' => false,
            'json' => false,
            'base64' => false,
            'url' => false,
        ];

        $abbreviations = [];

        foreach($valid_arguments as $k => $v)
        {
            $abbreviations[$k] = $k[0];
        }

        $abbreviations = [
            'test-payload' => false,
            'plus-numbers' => 'n',
            'phar-jpeg' => 'pj',
            'phar-prefix' => 'pp',
            'phar-filename' => 'pf',
            'new' => 'N'
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
                $arg === $abbreviations[$argument] ||
                $arg === '-' . $argument
            )
            {
                $valid = true;

                # Does it expect a parameter ?
                if($has_parameter)
                {
                    if($count <= $i + 1)
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
            $this->e('Unknown parameter: -' . $arg);
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
                $arguments += array_slice($argv, $i);
                break;
            }
            # This is a parameter or an option
            if(strlen($arg) >= 2 && $arg[0] == '-')
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
                    $this->list_gc(count($arguments) ? $arguments[0]: null);
                    return;
                case 'help':
                    $this->help();
                    return;
                case 'new':
                    if(count($arguments) < 2)
                    {
                        $this->o($this->_get_command_line(
                            '--new <Framework> <type>'
                        ));
                        return;
                    }
                    $this->new_gc($arguments[0], $arguments[1]);
                    return;
                case 'informations':
                    if(count($arguments) < 1)
                    {
                        $this->o($this->_get_command_line('-i <gadget_chain>'));
                        return;
                    }
                    $gc = $this->get_gadget_chain($arguments[0]);
                    $this->o($gc, 2);
                    $this->o($this->_get_command_line_gc($gc));
                    return;
            }
        }

        foreach($parameters as $key => $value)
        {
            switch($key)
            {
                case 'phar':
                    if(!in_array($value, ['phar', 'tar', 'zip']))
                    {
                        $this->e('"' . $value . '" is not a valid PHAR format');
                    }
                    break;
                case 'phar-jpeg':
                    if(!isset($parameters['phar']))
                    {
                        $parameters['phar'] = 'tar';
                    }
                    else if($parameters['phar'] != 'tar')
                    {
                        $this->e('"--phar-jpeg" implies "--phar tar"');
                    }
                    # fall through
                case 'phar-prefix':
                case 'wrapper':
                    if(!file_exists($value))
                    {
                        $this->e(
                            $key . ': File "' . $value . '" does not exist'
                        );
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
        $arguments = $gc::$parameters;

        $values = @array_combine($arguments, $parameters);

        if($values === false)
        {
            $this->o($gc, 2);
            $this->e(
                'Invalid arguments for type "' . $gc::$type . '" ' . "\n" .
                $this->_get_command_line_gc($gc)
            );
        }

        return $values;
    }

    protected function _get_command_line_gc($gc)
    {
        $arguments = array_map(function ($a) {
                return '<' . $a . '>';
        }, $gc::$parameters);
        return $this->_get_command_line($gc->get_name(), ...$arguments);
    }

    private function _get_command_line(...$arguments)
    {
        return './phpggc ' . implode(' ', $arguments);
    }
}
