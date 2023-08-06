<?php

namespace CodeIgniter\Publisher {
    class Publisher {
        private $scratch;

        public function __construct($remote_path) {
            $this->scratch = $remote_path;
        }
    }
}