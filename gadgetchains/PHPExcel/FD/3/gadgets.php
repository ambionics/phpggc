<?php

# https://github.com/PHPOffice/PHPExcel/blob/1.8.2/Classes/PHPExcel/Shared/XMLWriter.php
class PHPExcel_Shared_XMLWriter {
    private $tempFileName  = '';

    public function __construct($filePath) {
        $this->tempFileName = $filePath;
    }

    /*
    public function __destruct()
    {
        // Unlink temporary files
        if ($this->tempFileName != '') {
            @unlink($this->tempFileName);
        }
    }
    */
}