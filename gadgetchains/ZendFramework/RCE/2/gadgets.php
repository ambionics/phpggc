<?php

class Zend_Form_Element
{
    protected $_name;
    protected $_decorators = array();
    protected $_view;
    public $id;
    
    public $helper = 'formText';
    protected $_allowEmpty = true;
    protected $_autoInsertNotEmptyValidator = true;
    protected $_belongsTo;
    protected $_description;
    protected $_disableLoadDefaultDecorators = false;
    protected $_errorMessages = array();
    protected $_errors = array();
    protected $_errorMessageSeparator = '; ';
    protected $_filters = array();
    protected $_ignore = false;
    protected $_isArray = false;
    protected $_isError = false;
    protected $_isErrorForced = false;
    protected $_label;
    protected $_loaders = array();
    protected $_messages = array();
    protected $_order;
    protected $_required = false;
    protected $_translator;
    protected $_translatorDisabled = false;
    protected $_type;
    protected $_validators = array();
    protected $_validatorRules = array();
    protected $_value;
    protected $_isPartialRendering = false;
    protected $_concatJustValuesInErrorMessage = false;

    function __construct($_name, $id, $_decorators, $_view)
    {
    	$this->_name = $_name;
    	$this->id = $id;
    	$this->_decorators = $_decorators;
    	$this->_view = $_view;
    }
}

class Zend_Form_Decorator_Form extends Zend_Form_Decorator_Abstract
{
    protected $_helper = 'call';
}

abstract class Zend_Form_Decorator_Abstract
{
    protected $_placement = 'APPEND';
    protected $_element;
    protected $_options = array();
    protected $_separator = PHP_EOL;
}

class Zend_Cache_Frontend_Function
{
    protected $_specificOptions = array(
        'cache_by_default' => false,
        'cached_functions' => array(),
        'non_cached_functions' => array()
    );
}