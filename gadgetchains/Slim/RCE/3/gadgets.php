<?php

namespace Pimple
{
    class Container
    {
        private $raw;
        private $values;
        private $keys;

        function __construct($array)
        {
            $this->keys = $this->raw = $this->values = $array;
        }
    }
}

namespace Slim
{
    class App
    {
        private $container;

        function __construct($container)
        {
            $this->container = $container;
        }
    }

    class Container extends \Pimple\Container
    {

    }
}

namespace phpDocumentor\Reflection\DocBlock\Tags
{
    use \Slim\App;
    use \Slim\Container;

    class Method
    {
        private $arguments = [];
        protected $description;

        function __construct($function, $parameter)
        {
            $z = new App(new Container(['has' => $function]));
            $y = new App($z);
            $this->description = new App(new Container(['render' => [$y, $parameter]]));
        }
    }
}