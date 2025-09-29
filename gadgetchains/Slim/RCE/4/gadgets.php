<?php
namespace Prophecy\Argument\Token
{
    class ExactValueToken
    {
        private $util;
        private $value;

        function __construct($function, $parameter)
        {
            $this->util = new \AdrianSuter\Autoload\Override\ClosureHandler($function);
            $this->value = $parameter;
        }
    }
}

namespace AdrianSuter\Autoload\Override
{
    class ClosureHandler
    {
        private $closures;

        function __construct($function)
        {
            $this->closures = ["stringify"=>$function];
        }
    }
}