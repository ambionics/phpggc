<?php

namespace Monolog
{
    enum Level: int
    {
        case Debug = 100;
    }
    
    class LogRecord
    {
        public Level $level = \Monolog\Level::Debug;
        public string $message;
        public \DateTimeImmutable $datetime;
        
        function __construct($data)
        {
            $this->message = $data;
            $this->datetime = new \DateTimeImmutable;
        }
    }
}

namespace Monolog\Handler
{
    class DeduplicationHandler
    {
        protected string $deduplicationStore;
        protected int $bufferSize = 1;
        protected array $buffer;
        protected \Monolog\Level $deduplicationLevel = \Monolog\Level::Debug;
        
        public function __construct($data, $path)
        {
            $this->buffer = [new \Monolog\LogRecord($data)];
            $this->deduplicationStore = $path;
        }
    }
    
    class GroupHandler
    {
        protected array $handlers;
        
        public function __construct($data, $path) 
        {
            $this->handlers = [new \Monolog\Handler\DeduplicationHandler($data, $path)];
        }
    } 
}