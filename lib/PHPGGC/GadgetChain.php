<?php

namespace PHPGGC;

abstract class GadgetChain
{
    public $name;
    public static $type;
    public $version = '?';
    # Vector to start the chain: __destruct, __toString, offsetGet, etc.
    public $vector = '';
    public $author = '';
    public $parameters = [];
    public $informations;

    # Types
    const TYPE_RCE = 'rce';
    const TYPE_FI = 'file_include';
    const TYPE_FR = 'file_read';
    const TYPE_FW = 'file_write';
    const TYPE_FD = 'file_delete';
    const TYPE_SQLI = 'sql_injection';

    public function __toString()
    {
        $infos = [
            'Name' => $this->get_name(),
            'Version' => $this->version,
            'Type' => $this::$type,
            'Vector' => $this->vector
        ];

        $strings = [];

        if($this->informations)
        {
            $informations = trim($this->informations);
            $informations = preg_replace("#\n\s+#", "\n", $informations);
            $infos['Informations'] = "\n" . $informations;
        }

        foreach($infos as $k => $v)
        {
            $strings[] = str_pad($k, 15) . ': ' . $v;
        }

        return implode("\n", $strings);
    }

    public function get_name()
    {
        $class = get_class($this);
        $class = substr($class, strpos($class, '\\') + 1);
        $class = str_replace('\\', '/', $class);
        return $class;
    }

    public function load_gadgets()
    {
        $file = dirname((new \ReflectionClass($this))->getFileName());
        require $file . '/gadgets.php';
    }

    /**
     * Modifies given parameters if required.
     */
    public function pre_process(array $parameters)
    {
        return $parameters;
    }

    abstract public function generate(array $parameters);

    /**
     * Changes some values in the unserialize payload.
     * For instance, if a class is meant to be named A\B\C but has been named
     * A_B_C in the gadget for convenience, it can be str_replace()d here.
     */
    public function post_process($payload)
    {
        return $payload;
    }
}
