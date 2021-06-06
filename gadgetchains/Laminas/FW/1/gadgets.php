<?php

namespace Laminas\Cache\Storage\Adapter
{
    class AdapterOptions
    {
        protected $namespace;
        protected $keyPattern;

        function __construct()
        {
            $this->namespace = '';
            $this->keyPattern = '/.*/';
        }
    }

    class FilesystemOptions extends AdapterOptions
    {
        protected $cacheDir;
        protected $dirLevel;
        protected $suffix;

        function __construct($cacheDir, $extension)
        {
            parent::__construct();
            $this->cacheDir = $cacheDir;
            $this->suffix = $extension;
            $this->dirLevel = 0;
        }
    }

    class Filesystem
    {
        protected $options;

        function __construct($options)
        {

            $this->options = $options;
        }
    }
}

namespace Laminas\Cache\Psr\CacheItemPool
{
    class CacheItemPoolDecorator
    {
        protected $storage;
        protected $deferred;

        function __construct($storage, $deferred)
        {
            $this->storage = $storage;
            $this->deferred = $deferred;
        }
    }

    class CacheItem
    {
        protected $key;
        protected $value;

        function __construct($key, $value)
        {
            $this->key = $key;
            $this->value = $value;
        }
    }
}
