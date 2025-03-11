<?php

namespace League\Plates\Template
{
    class Template
    {
        protected $name;
        protected $engine;

        public function __construct(object $Engine, string $parameter = null)
        {
            if($parameter !== null)
            {
                $this->name = $parameter;
            }

            $this->engine = $Engine;
        }
    }

    class Functions
    {
        protected $functions = array();

        public function __construct(object $Func)
        {
            $this->functions = [
                "getResolveTemplatePath" => $Func
            ];
        }
    }

    class Func
    {
        protected $callback;
        protected $name;

        public function __construct($function)
        {
            $this->name = $function;

            $this->callback = [
                $this,
                'getName'
            ];
        }
    }
}

namespace League\Plates
{
    class Engine
    {
        protected $functions;
        
        public function __construct(object $Functions)
        {
            $this->functions = $Functions;
        }
    }
}