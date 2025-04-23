<?php

class TCPDF
{
    public $file_id;
    public $imagekeys;

    function __construct($remote_path) {
        $this->file_id = 1;
        $this->imagekeys = ['/tmp/..' . $remote_path];
    }
}
