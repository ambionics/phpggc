<?php

namespace Illuminate\Broadcasting
{
    class PendingBroadcast
    {
        protected $events;

        function __construct($events)
        {
            $this->events = $events;
        }
    }
}


namespace Illuminate\Notifications
{
    class ChannelManager
    {
        protected $app;
        protected $defaultChannel;
        protected $customCreators;

        function __construct($function, $parameter)
        {
            $this->app = $parameter;
            $this->customCreators = ['x' => $function];
            $this->defaultChannel = 'x';
        }
    }
}