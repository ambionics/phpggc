<?php
    
class CDbCriteria
{
    public $params;

    function __construct($function, $param)
    {
        $this->params = new CMapIterator($function, $param);
    }
}

class CMapIterator
{
    private $_d;
    private $_keys;
    private $_key;

    function __construct($function, $param)
    {
        $this->_keys = [$param];
        $this->_key = $param;
        $this->_d = new CForm($function);
    }
}

class CForm
{
    private $_elements;

    function __construct($function)
    {
        $this->_elements = new PHPUnit_Extensions_Selenium2TestCase_Session($function);
    }
}

class PHPUnit_Extensions_Selenium2TestCase_Session
{
    protected $commands;
    protected $url;
    protected $driver;

    function __construct($function)
    {
        $this->commands = ['itemAt' => $function];
        $this->url = new PHPUnit_Extensions_Selenium2TestCase_URL();
        $this->driver = new DocBlox_Parallel_Worker();
    }
}

class PHPUnit_Extensions_Selenium2TestCase_URL
{
    function __construct()
    {
        
    }
}

class DocBlox_Parallel_Worker
{
    function __construct()
    {
        
    }
}