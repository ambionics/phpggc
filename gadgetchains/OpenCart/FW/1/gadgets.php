<?php

namespace Opencart\System\Library\DB
{
    class MySQLi
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

    class Log
    {
        private string $file;

        public function __construct($file) {
            $this->file = $file;
        }
    }
}
