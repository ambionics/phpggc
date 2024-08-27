<?php

class Zend_Memory_Manager
{
    private $_backend;
    private $_tags;

    public function __construct($path, $data)
    {
        $this->_backend = new \Zend_Log($path, $data);
        $this->_tags = 'any';
    }
}


class Zend_Log
{
    protected $_priorities;
    protected $_writers;
    protected $_timestampFormat = 'c';
    protected $_extras = [];
    protected $_filters = [];

    public function __construct($path, $data)
    {
        $this->_priorities = [1=>'CLEAN'];
        $this->_writers = [new \Zend_CodeGenerator_Php_File($path, $data)];
    }
}

abstract class Zend_CodeGenerator_Php_Abstract
{
    protected $_isSourceDirty = false;

    public function __construct()
    {
    }
}

class Zend_CodeGenerator_Php_File extends \Zend_CodeGenerator_Php_Abstract
{
    protected $_filename;
    protected $_docblock;
    protected $_sourceContent;
    protected $_classes = [];
    
    public function __construct($path, $data)
    {
        $this->_filename = $path;
        $this->_docblock = new \Zend_CodeGenerator_Php_Docblock();
        $this->_sourceContent = $data;
    }
}

class Zend_CodeGenerator_Php_Docblock extends \Zend_CodeGenerator_Php_Abstract
{
    public function __construct()
    {
    }
}