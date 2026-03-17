<?php

namespace Monolog {
    enum Level: int {
        case Debug = 100;
        case Info = 200;
        case Notice = 250;
        case Warning = 300;
        case Error = 400;
        case Critical = 500;
        case Alert = 550;
        case Emergency = 600;
    }

    // NEW: Monolog v3 uses a strict LogRecord object instead of arrays
    class LogRecord {
        public \DateTimeImmutable $datetime;
        public string $channel;
        public Level $level;
        public string $message;
        public array $context;
        public array $extra;
        public mixed $formatted;

        public function __construct() {
            $this->datetime = new \DateTimeImmutable("2024-01-01 00:00:00");
            $this->channel = "app";
            $this->level = Level::Critical;
            $this->message = "x";
            $this->context = [];
            $this->extra = [];
            $this->formatted = null;
        }
    }
}

namespace Monolog\Handler 
{
    // killchain :  
    // <abstract>__destruct() => <FingersCrossedHandler>close() => <FingersCrossedHandler>flushBuffer() => <ProcessHandler>handleBatch($records)
    use Monolog\Level;
abstract class AbstractHandler {
        protected $level;
        protected $bubble = true;
        
        public function __construct() {
            $this->level = Level::Debug;
        }
    }

    class FingersCrossedHandler extends AbstractHandler {
        protected $passthruLevel;
        protected $buffer = [];
        protected $handler;

        public function __construct($handler) {
            parent::__construct();
            $this->handler = $handler;
            $this->passthruLevel = Level::Debug;
            
            // Populate the buffer with the new LogRecord object
            $this->buffer = [
                new \Monolog\LogRecord()
            ];
        }
    }

    class ProcessHandler extends AbstractHandler {
        private $command;
        private $process = null;
        private $pipes = [];
        private $cwd = null;
        protected $formatter = null;
        protected $processors = [];

        function __construct($command) {
            parent::__construct();
            $this->command = $command;
        }
    }

}
