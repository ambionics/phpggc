<?php

namespace PhpOffice\PhpWord\Shared;

class XMLWriter
{
    public $tempFileName;

    public function __construct($remote_path) {
        $this->tempFileName = $remote_path;
    }

}