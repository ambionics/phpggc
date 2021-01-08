<?php

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
            unlink($this->_fileName);
        }
        $this->_fileHandle = null;
    }   //  function __destruct()
    */
}