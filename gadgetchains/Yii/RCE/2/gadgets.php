<?php

namespace Prophecy\Argument\Token
{
    class ExactValueToken
    {
        private $util;
        private $value;

        function __construct($function, $parameter)
        {
            $this->util = new \PHPUnit_Extensions_Selenium2TestCase_Session($function);
            $this->value = $parameter;
        }
    }
}

namespace
{
    class WikiPublishTask
    {
        private $cookiesFile;

        function __construct($function, $parameter)
        {
            $this->cookiesFile = new \Prophecy\Argument\Token\ExactValueToken(
                $function, $parameter
            );
        }
    }

    class PHPUnit_Extensions_Selenium2TestCase_Session
    {
        protected $commands;
        protected $url;
        protected $driver;

        function __construct($function)
        {
            $this->commands = ['stringify' => $function];
            $this->url = new PHPUnit_Extensions_Selenium2TestCase_URL();
            $this->driver = new DocBlox_Parallel_Worker();
        }
    }

    class PHPUnit_Extensions_Selenium2TestCase_URL
    {
    }

    class DocBlox_Parallel_Worker
    {
    }
}
