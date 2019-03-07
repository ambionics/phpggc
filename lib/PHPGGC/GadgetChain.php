<?php

namespace PHPGGC;

abstract class GadgetChain
{
    public $name;
    public static $type;
    public static $version = '?';
    # Vector to start the chain: __destruct, __toString, offsetGet, etc.
    public static $vector = '';
    public static $author = '';
    public static $parameters = [];
    public static $informations;

    # Types
    const TYPE_RCE = 'rce';
    const TYPE_FI = 'file_include';
    const TYPE_FR = 'file_read';
    const TYPE_FW = 'file_write';
    const TYPE_FD = 'file_delete';
    const TYPE_SQLI = 'sql_injection';

    function __construct()
    {
        $this->load_gadgets();
    }

    protected function load_gadgets()
    {
        $directory = dirname((new \ReflectionClass($this))->getFileName());
        require_once $directory . '/gadgets.php';
    }

    /**
     * Generates the gadget chain object.
     */
    abstract public function generate(array $parameters);

    /**
     * Modifies given parameters if required.
     */
    public function process_parameters(array $parameters)
    {
        return $parameters;
    }

    /**
     * Modifies given object if required.
     */
    public function process_object(array $object)
    {
        return $object;
    }

    /**
     * Changes some values in the unserialize payload.
     * For instance, if a class is meant to be named A\B\C but has been named
     * A_B_C in the gadget for convenience, it can be str_replace()d here.
     */
    public function process_serialized($serialized)
    {
        return $serialized;
    }

    public function __toString()
    {
        $infos = [
            'Name' => static::get_name(),
            'Version' => static::$version,
            'Type' => static::$type,
            'Vector' => static::$vector
        ];

        $strings = [];

        if(static::$informations)
        {
            $informations = trim(static::$informations);
            $informations = preg_replace("#\n\s+#", "\n", $informations);
            $infos['Informations'] = "\n" . $informations;
        }

        foreach($infos as $k => $v)
        {
            $strings[] = str_pad($k, 15) . ': ' . $v;
        }

        return implode("\n", $strings);
    }

    public static function get_name()
    {
        $class = static::class;
        $class = substr($class, strpos($class, '\\') + 1);
        $class = str_replace('\\', '/', $class);
        return $class;
    }
}
