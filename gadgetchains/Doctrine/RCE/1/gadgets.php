<?php

namespace Doctrine\Common\Cache\Psr6
{
    class CacheAdapter
    {
        public $deferredItems = true;
        public $loader = 1;
    }
    
    class TypedCacheItem
    {
        public $expiry = 99999999999999999;
        public $value = "test";
    }

    class CacheItem
    {
        public $expiry = 99999999999999999;
        public $value = "test";
    }

}

namespace Symfony\Component\Cache\Adapter
{
    class PhpArrayAdapter
    {
        public $file = "/tmp/aaa.mocksess"; // fixed at the time
    }
}


namespace Symfony\Component\HttpFoundation\Session\Storage
{
    class MockFileSessionStorage
    {
        public $started = true;
        public $savePath = "/tmp"; // Produces /tmp/aaa.mocksess
        public $id = "aaa";
    }

    class MetadataBag
    {
        public $storageKey = "a";
    }
}