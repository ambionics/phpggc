<?php

namespace Knp\Snappy;

class Image
{
    public $temporaryFiles = [];

    public function __construct($remote_path) {
        array_push($this->temporaryFiles, $remote_path);
    }

}