<?php

namespace Grav\Framework\Cache\Adapter {
    class FileCache
    {
        private $tmp;

        public function __construct($tmp)
        {
            $this->tmp = $tmp;
        }
    }
}