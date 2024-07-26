<?php

namespace Spiral\Files
{
    class Files
    {
        private $destructFiles = [];

        public function __construct($remote_path) {
            array_push($this->destructFiles, $remote_path);
        }

    }
}