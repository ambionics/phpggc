<?php

require_once(DIR_GADGETCHAINS . '/WordPress/generic/gadgets.php');

class PHPExcel_CachedObjectStorage_Memcache {
    protected $_currentObjectID;
    protected $_currentCellIsDirty=true;
    protected $_currentObject;
    private $_memcache;
    private $_cachePrefix='x';

    public function __construct($_currentObjectID) {
        $this->_currentObjectID = $_currentObjectID;
        $this->_currentObject = new \PHPExcel_Cell();
        $this->_memcache = new \WP_Object_Cache();
    }
}

class WP_Object_Cache
{
    public function __construct() {
    }
}

class PHPExcel_Cell
{
    public function __construct() {
    }
}

class PHPExcel_RichText {
    private $_richTextElements;

    public function __construct($richTextElements) {
        $this->_richTextElements = $richTextElements;
    }
}