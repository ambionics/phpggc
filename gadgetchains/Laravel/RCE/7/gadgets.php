<?php

namespace Illuminate\Broadcasting
{
    class PendingBroadcast
    {
        protected $events;
        protected $event;

        public function __construct($function, $parameter)
        {
            $this->events = new \Illuminate\Bus\Dispatcher($function); 
            $this->event = new \Illuminate\Queue\CallQueuedClosure($parameter); 
        }
    }
}

namespace Illuminate\Bus
{
    class Dispatcher
    {
        protected $queueResolver;

        public function __construct($function)
        {
            $this->queueResolver = $function;

        }
    }
}

namespace Illuminate\Queue
{
    class CallQueuedClosure
    {
        protected $connection;

        public function __construct($parameter)
        {
            $this->connection = $parameter;
        }
    }
}


