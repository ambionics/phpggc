<?php

namespace App
{
    class App
    {
        protected $finalizer;

        function __construct($function,$param)
        {
            $this->finalizer = new \Spiral\Boot\Finalizer($function,$param);
        }
    }
}

namespace Spiral\Boot
{
    class Finalizer
    {
        private $finalizers;

        function __construct($function,$param)
        {
            $this->finalizers = [[new \PhpOption\LazyOption($function,$param),"get"]];
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