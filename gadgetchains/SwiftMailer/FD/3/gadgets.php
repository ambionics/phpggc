<?php

class Swift_KeyCache_DiskKeyCache
{
    private $_path;
    private $_keys;

    public function __construct($filepath)
    {
        $parts = explode('/',$filepath);
        $this->_path = array_shift($parts);
        $filename = array_pop($parts);
        $midpath = implode('/',$parts);
        $this->_keys = [$midpath => [$filename => '']];
    }
}