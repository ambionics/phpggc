<?php

namespace Swoft\Session
{
    class SwooleStorage
    {
        private $db;

        function __construct($function, $parameter)
        {
            $this->db = new \Swoft\Http\Session\HttpSession($function, $parameter);
        }
    }
}

namespace Swoft\Http\Session
{
    class HttpSession
    {
        private $handler;
        private $sessionId;

        function __construct($function, $parameter)
        {
            $this->sessionId = 'x';
            $this->handler = new \Swoft\Console\Style\Style($function, $parameter);
        }
    }
}

namespace Swoft\Console\Style
{
    class Style
    {
        private $styles;
        
        function __construct($function, $parameter)
        {
            $this->styles = new \Dotenv\Environment\DotenvVariables($function, $parameter);
        }
    }
}

namespace Dotenv\Environment
{
    class DotenvVariables
    {
        protected $adapters;

        function __construct($function, $parameter)
        {
            $this->adapters = new \PhpOption\LazyOption($function, $parameter);
        }
    }
}

namespace PhpOption
{
    class LazyOption
    {
        private $callback;
        private $arguments;

        function __construct($function, $parameter)
        {
            $this->callback = $function;
            $this->arguments = [$parameter];
        }
    }
}