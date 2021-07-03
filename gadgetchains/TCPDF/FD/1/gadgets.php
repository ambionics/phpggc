<?php

class TCPDF {
    protected $imagekeys;
    
    function __construct($remote_path) {
		$this->imagekeys = [
		    $remote_path
        ];
    }
}
