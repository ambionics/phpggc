<?php

require_once(DIR_GADGETCHAINS . '/WordPress/generic/gadgets.php');

class PHPExcel_CachedObjectStorage_SQLite {
    private $_DBHandle;
    private $_TableName;

    public function __construct($_TableName) {
        $this->_TableName = $_TableName;
        $this->_DBHandle = new SQLiteDatabase(':memory:'); // require extension
    }
}

class PHPExcel_RichText {
    private $_richTextElements;

    public function __construct($richTextElements) {
        $this->_richTextElements = $richTextElements;
    }
}