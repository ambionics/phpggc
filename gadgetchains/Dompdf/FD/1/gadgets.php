<?php

namespace Dompdf;

class Cpdf
{
    public $imageCache = [];

    public function __construct($remote_path) {
        array_push($this->imageCache, $remote_path); 
    }

}
