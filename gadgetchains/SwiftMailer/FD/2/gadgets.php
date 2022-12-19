<?php

class Swift_Image
{
    private $_cache;
    private $_cacheKey;

    public function __construct($path)
    {
        $path_a = explode("/", $path);
        $this->_cacheKey = $path_a[count($path_a) - 2];
        $pre_index = strripos($path, "/");
        $pre = substr($path, 0, $pre_index - strlen($this->_cacheKey) - 1);
        
        $this->_cache = new Swift_KeyCache_DiskKeyCache(
            $pre, $path_a[count($path_a) - 2], $path_a[count($path_a) - 1]
        );
    }
}

class Swift_KeyCache_DiskKeyCache
{
    private $_path;
    private $_keys;

    public function __construct($pre_path, $path, $filename)
    {
        $this->_path = $pre_path;
        $this->_keys = [$path => [$filename => '']];
    }
}
