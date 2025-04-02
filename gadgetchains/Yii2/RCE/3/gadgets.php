<?php

namespace yii\db
{
    class BatchQueryResult
    {
        private $_dataReader;

        function __construct($function,$param)
        {
            $this->_dataReader = new \Faker\ValidGenerator($function,$param);
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
