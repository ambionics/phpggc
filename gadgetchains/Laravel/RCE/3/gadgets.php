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

        function __construct($cmd)
        {
            $this->app = $cmd;
            $this->customCreators = ['x' => 'assert'];
            $this->defaultChannel = 'x';
        }
    }
}