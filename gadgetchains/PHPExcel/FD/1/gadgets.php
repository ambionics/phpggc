<?php

# https://github.com/PHPOffice/PHPExcel/blob/1.8.2/Classes/PHPExcel/CachedObjectStorage/DiscISAM.php
class PHPExcel_CachedObjectStorage_DiscISAM {
    private $fileName = null;
    private $fileHandle = 42;

    public function __construct($filePath) {
        $this->fileName = $filePath;
    }

    /*
    public function __destruct() {
        if (!is_null($this->fileHandle)) {
            fclose($this->fileHandle); // Will only produce a warning
            unlink($this->fileName);
        }
        $this->fileHandle = null;
    }
    */
}