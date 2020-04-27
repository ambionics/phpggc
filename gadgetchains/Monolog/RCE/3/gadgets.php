<?php

namespace Monolog\Handler
{
    class NativeMailerHandler {
        protected $to = null;
        protected $subject = null;
        protected $headers = null;

        protected $level = null;
        protected $bubble = false;
        protected $formatter = null;
        protected $processors;

        function __construct($methods) {
            $this->processors = $methods;

        }
    }

    class BufferHandler
    {
        protected $handler;
        protected $bufferSize = -1;
        protected $buffer;

        # ($record['level'] < $this->level) == false
        protected $level = null;
        protected $bubble = false;
        protected $formatter = null;
        protected $processors;

        function __construct($methods, $command)
        {
            $this->processors = null;
            $this->buffer = [$command];
            $this->handler = new NativeMailerHandler($methods);
        }
    }
}
