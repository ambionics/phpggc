<?php

namespace Monolog\Handler
{
    class LogMonsterHandler
    {
        protected $processors;
        protected int $hunger = 1;
        protected string $channel;
        protected \Monolog\Level $angerLevel = \Monolog\Level::Info;
        
        function __construct($function, $parameter)
        {
            $this->processors = ['get_object_vars', 'next', $function];
            $this->channel = $parameter;
        }
    }
}

namespace Monolog
{
    enum Level: int
    {
        case Info = 100;
    }
}