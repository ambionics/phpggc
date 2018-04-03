<?php

namespace Illuminate\Broadcasting
{
    class PendingBroadcast
    {
        protected $events;
        protected $event;

        function __construct($events, $cmd)
        {
            $this->events = $events;
            $this->event = $cmd;
        }
    }
}


namespace Illuminate\Events
{
    class Dispatcher
    {
        protected $listeners;

        function __construct($cmd)
        {
            $this->listeners = [
                $cmd => ['assert']
            ];
        }
    }
}