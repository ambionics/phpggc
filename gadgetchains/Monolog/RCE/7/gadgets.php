<?php
namespace Monolog\Handler
{
    class FingersCrossedHandler
    {
    	protected $passthruLevel = 0;
        protected $handler;
        protected $buffer;
        protected $processors;
        
        function __construct($methods,$command)
        {
            $this->processors = $methods;
            $this->buffer = [$command];
            $this->handler = $this;
        }
    }
}
