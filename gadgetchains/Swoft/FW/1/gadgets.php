<?php

namespace Monolog\Handler
{
    class RollbarHandler
    {
        private $hasRecords = true;
        protected $rollbarNotifier;

        function __construct($path, $data)
        {
            $this->rollbarNotifier = new \PHPUnit\Runner\ResultCacheExtension($path, $data);
        }
    }
}

namespace PHPUnit\Runner
{

    class ResultCacheExtension
    {
        private $cache;

        function __construct($path, $data)
        {
            $this->cache = new DefaultTestResultCache($path, $data);
        }
    }

    class DefaultTestResultCache
    {
        private $cacheFilename;
        private $defects;

        function __construct($path, $data)
        {
            $this->cacheFilename = $path;
            $this->defects = $data;
        }

    }
}