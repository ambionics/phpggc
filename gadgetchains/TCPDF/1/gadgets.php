<?php

class TCPDF {
    protected $imagekeys;
    
    function __construct($remote_file) {
		$this->imagekeys=array($remote_file);
	    }
}
