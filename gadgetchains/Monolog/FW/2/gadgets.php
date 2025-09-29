<?php

namespace Monolog\Handler
{
    class DeduplicationHandler
    {
        protected $bufferSize = 1;
        protected $buffer;
        protected $deduplicationLeve=0;
        protected $deduplicationStore;
        protected $time=0;
        
        public function __construct($path, $data)
        {
            $this->buffer = [["level"=>1,"message"=>$data,'datetime'=>new \Gelf\Message(),'level_name'=>'']];
            $this->deduplicationStore = $path;
        }
    }

    class GroupHandler
    {
        protected $handlers;

        public function __construct($path, $data)
        {
            $this->handlers = [new DeduplicationHandler($path, $data)];
        }
    }
}

namespace Gelf
{
    class Message
    {
        protected $timestamp=0;

        public function __construct()
        {
        }
    }
}