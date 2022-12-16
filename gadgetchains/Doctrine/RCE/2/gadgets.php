<?php

namespace Doctrine\Common\Cache\Psr6
{

    class CacheAdapter
    {
        public $deferredItems = true;
    }

}

namespace Symfony\Component\Cache\Traits
{
    class RedisProxy
    {
        public $redis;
        
        public function __construct ($parameter)
        {
            $this->redis = $parameter;
        }

    }
}

namespace Doctrine\Bundle\DoctrineBundle\Dbal
{
    class SchemaAssetsFilterManager
    {
        public $schemaAssetFilters;
        public function __construct ($function)
        {
            $this->schemaAssetFilters = [$function];
        }
    }
}