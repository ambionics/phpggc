<?php

namespace Opencart\System\Library\DB
{
    class mysqli
    {
        private object|null $connection;

        function __construct($connection)
        {
            $this->connection = $connection;
        }
    }
}

namespace Opencart\System\Library
{
    class Session
    {
        protected object $adaptor;
        protected string $session_id;

        public function __construct($adaptor, $session_id)
        {
            $this->adaptor = $adaptor;
            $this->session_id = $session_id;
        }
    }
}

namespace Opencart\System\Engine
{
    Class Proxy
    {
        protected $data = [];

        public function __construct($key, $function)
        {
            $this->data[$key] = $function;
        }
    }
}
