<?php
namespace Illuminate\Contracts\Queue
{
    interface ShouldQueue
    {
    }
}

namespace Illuminate\Bus
{
    class Dispatcher
    {
        protected $container;
        protected $pipeline;
        protected $pipes = [];
        protected $handlers = [];
        protected $queueResolver;
        function __construct($function)
        {
            $this->queueResolver = $function;

        }
    }
}

namespace Illuminate\Broadcasting
{
    use Illuminate\Contracts\Queue\ShouldQueue;

    class BroadcastEvent implements ShouldQueue
    {
        function __construct()
        {

        }
    }

    class PendingBroadcast
    {
        protected $events;
        protected $event;
        
        function __construct($dispatcher,$param)
        {
            $this->event = new BroadcastEvent();
            $this->event->connection = $param;
            $this->events = $dispatcher;
        }
    }
}

