<?php

namespace Illuminate\Broadcasting
{
    class PendingBroadcast
    {
        protected $events;
        protected $event;

        function __construct($events, $event)
        {
            $this->events = $events;
            $this->event = $event;
        }
    }
}


namespace Illuminate\Validation
{
    class Validator
    {
        public $extensions;

        function __construct($function)
        {
            $this->extensions = ['' => $function];
        }
    }
}