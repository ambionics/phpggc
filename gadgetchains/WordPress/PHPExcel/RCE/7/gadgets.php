<?php

require_once(DIR_GADGETCHAINS . '/WordPress/generic/gadgets.php');

class PHPExcel_Comment {
    private $_text;

    public function __construct($_text) {
        $this->_text = $_text;
    }
}

class PHPExcel_RichText {
    private $_richTextElements;

    public function __construct($richTextElements) {
        $this->_richTextElements = $richTextElements;
    }
}