<?php

namespace TYPO3\CMS\Extbase\Reflection
{
    class ReflectionService
    {
        protected $dataCacheNeedsUpdate=true;
        private $cachingEnabled=true;
        protected $dataCache;
        protected $classSchemata; 

        public function __construct($path, $data) {
            $this->dataCache = new \TYPO3\CMS\Core\Cache\Backend\FileBackend($path);
            $this->classSchemata = $data;
        }
    }
}

namespace TYPO3\CMS\Core\Cache\Backend
{
    class FileBackend
    {
        protected $cacheDirectory;
        protected $cacheEntryFileExtension;
        protected $defaultLifetime=0;

        public function __construct($path) {
            $info = pathinfo($path);
            $this->cacheDirectory = $info["dirname"] . '/';
            $this->cacheEntryFileExtension = '/../' . $info['basename'];
        }
    }
}