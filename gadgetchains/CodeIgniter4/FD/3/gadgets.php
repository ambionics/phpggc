<?php

namespace CodeIgniter\Cache\FactoriesCache
{
    class FileVarExportHandler 
    {
        public $path = "";
    }
}

namespace CodeIgniter\Autoloader
{
    class FileLocatorCached
    {
        public $cacheUpdated = true;
        public $cacheKey;
        public $cache = [""];
        public $cacheHandler;
        
        public function __construct($remote_path) 
        {
            $this->cacheKey = $remote_path;
        }
    }
}