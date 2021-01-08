<?php

# https://github.com/PHPOffice/PHPExcel/blob/1.8.1/Classes/PHPExcel/Shared/XMLWriter.php
class PHPExcel_Shared_XMLWriter {
    private $_tempFileName  = '';

    public function __construct($filePath) {
        $this->_tempFileName = $filePath;
    }

    /*
    public function __destruct()
    {
        // Unlink temporary files
        if ($this->_tempFileName != '') {
            @unlink($this->_tempFileName);
        }
    }
    */
}