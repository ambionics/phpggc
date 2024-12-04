<?php

namespace SilverStripe\Assets {
    class InterventionBackend
    {
        private $tempPath;

        public function __construct($tempPath)
        {
            $this->tempPath = $tempPath;
        }
    }
}