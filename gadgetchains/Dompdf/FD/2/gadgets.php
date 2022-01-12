<?php

namespace Dompdf\Adapter {
    use Dompdf\Dompdf;

    class CPDF
    {
        public $_dompdf;
        public $_image_cache = [];

        public function __construct($remote_path) {
            $this->_dompdf = new Dompdf();
            array_push($this->_image_cache, $remote_path); 
        }
    }
}

namespace Dompdf {
    class Options {
        public $debugPng = false;
    }

    class Dompdf {
        public $options;
        
        public function __construct() {
            $this->options = new Options();
        }
    }
}