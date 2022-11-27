<?php

namespace JakubOnderka\PhpParallelLint{
    class FileWriter {
        protected $logFile;
        protected $buffer;

        function __construct($data, $path)
        {
            $this->logFile = $path;
            $this->buffer = $data;
        }
    }
}