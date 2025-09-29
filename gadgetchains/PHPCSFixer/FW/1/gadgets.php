<?php

namespace PhpCsFixer\Cache
{
    class FileCacheManager
    {
        private $cache;
        private $handler;

        function __construct($remote_path, $data)
        {
            $this->cache = new Cache($data);
            $this->handler = new FileHandler($remote_path);
        }
    }

    class FileHandler
    {
        private $file;

        function __construct($file_path)
        {
            $this->file = $file_path;
        }
    }

    class Signature
    {
        private $phpVersion = '';
        private $fixerVersion = '';
        private $indent = '';
        private $lineEnding = '';
        private $rules = [];

        function __construct(){}
    }

    class Cache
    {
        private $hashes;
        private $signature;

        function __construct($data) {
            $this->hashes = $data;
            $this->signature = new Signature();
        }
    }
}