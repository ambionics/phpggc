<?php

namespace Illuminate\Broadcasting {
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

namespace League\CommonMark\Environment {
    class Environment {
        private bool $extensionsInitialized = true;
        private $listenerData; // private PrioritizedList $listenerData;

        function __construct($listenerData) {
            $this->listenerData = $listenerData;
        }
    }
}

namespace League\CommonMark\Event {
    class ListenerData {
        private string $event = '\Illuminate\Broadcasting\Channel';
        private $listener;

        function __construct($listener) {
            $this->listener = $listener;
        }
    }
}

namespace League\CommonMark\Util {
    class PrioritizedList {
        private array $list = [];

        function __construct($list) {
            $this->list[][] = $list;
        }
    }
}

namespace Illuminate\Broadcasting {
    class Channel {
        public $name;

        function __construct($name) {
            $this->name = $name;
        }
    }
}

namespace Illuminate\Support\Testing\Fakes {
    class ChainedBatchTruthTest {
        protected $callback;

        function __construct($callback) {
            $this->callback = $callback;
        }
    }
}