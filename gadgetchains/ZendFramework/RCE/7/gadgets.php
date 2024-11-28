<?php

class Zend_Http_Response_Stream
{
    protected $stream_name;
    protected $_cleanup=true;

    function __construct($function, $parameter)
    {
        $this->stream_name = new \Zend_Dojo_View_Helper_Dojo_Container($function, $parameter);
    }
}

class Zend_Dojo_View_Helper_Dojo_Container
{
    protected $_enabled=true;
    public $view;
    protected $_localPath='x';
    protected $_stylesheetModules=[];
    protected $_stylesheets=[];
    protected $_registerDojoStylesheet=false;
    protected $_modulePaths;

    public function __construct($function, $parameter) 
    {
        $this->view = new \Zend_View($function);
        $this->_modulePaths = [$parameter=>""];
    }
}

class Zend_View_Helper_Doctype
{
    public function __construct() 
    {
    }
}

abstract class Zend_View_Abstract
{
    private $_escape;
    private $_helper;

    public function __construct($function) 
    {
        $this->_escape = $function;
        $this->_helper = ["Doctype"=>new \Zend_View_Helper_Doctype()];
    }
}

class Zend_View extends \Zend_View_Abstract
{
    public function __construct($function) 
    {
        parent::__construct($function);
    }
}