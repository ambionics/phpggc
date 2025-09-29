<?php

namespace Spiral\Composer
{
    class Downloader
    {
        private $dir;

        public function __construct($remote_path) {
            $this->dir = $remote_path;
        }
    }
}