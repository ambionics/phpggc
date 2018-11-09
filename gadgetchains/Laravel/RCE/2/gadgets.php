<?php

namespace Illuminate\Broadcasting
{
    class PendingBroadcast
    {
        protected $events;
        protected $event;

        function __construct($events, $parameter)
        {
            $this->events = $events;
            $this->event = $parameter;
        }
    }
}


namespace Illuminate\Events
{
    class Dispatcher
    {
        protected $listeners;

        function __construct($function, $parameter)
        {
            $this->listeners = [
                $parameter => [$function]
            ];
        }
    }
}