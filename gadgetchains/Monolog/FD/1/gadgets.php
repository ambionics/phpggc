<?php

namespace Monolog\Handler{

    class RotatingFileHandler
    {
        protected $mustRotate=true;
        protected $filenameFormat='{filename}';
        protected $dateFormat='Y-m-d_H-i-s';
        protected $filename;
        protected $maxFiles=-1;
    
        function __construct($path)
        {
            $this->filename = $path;
        }
    }
}