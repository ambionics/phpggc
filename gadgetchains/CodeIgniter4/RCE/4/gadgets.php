<?php

namespace CodeIgniter\Cache\Handlers
{
    class RedisHandler
    {
        protected $redis;

        public function __construct($func, $param)
        {
            $this->redis = new \CodeIgniter\Session\Handlers\MemcachedHandler(
                new \CodeIgniter\Model(
                    new \CodeIgniter\Database\BaseBuilder,
                    new \CodeIgniter\Validation\Validation,
                    $func
                ),
                $param
            );
        }
    }
}

namespace CodeIgniter\Session\Handlers
{
    class MemcachedHandler
    {
        protected $memcached;
        protected $lockKey;

        public function __construct($memcached, $param)
        {
            $this->lockKey = $param;
            $this->memcached = $memcached;
        }
    }
}

namespace CodeIgniter
{
    class Model
    {
        protected $builder;
        protected $primaryKey;
        protected $beforeDelete;
        protected $validationRules;
        protected $validation;

        public function __construct($builder, $validation, $func)
        {
            $this->builder = $builder;
            $this->primaryKey = null;

            $this->beforeDelete = array();
            $this->beforeDelete[] = "validate";

            $this->validation = $validation;
            $this->validationRules = array(
                "id" => array($func)
            );
        }
    }
}

namespace CodeIgniter\Validation
{
    class Validation
    {
        protected $ruleSetFiles;

        public function __construct()
        {
            $this->ruleSetFiles = array("finfo");
        }
    }
}

namespace CodeIgniter\Database
{
    class BaseBuilder
    { 
    }
}
