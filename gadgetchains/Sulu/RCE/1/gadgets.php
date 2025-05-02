<?php

namespace Goodby\CSV\Export\Standard\Collection
{
  class CallbackCollection
  {
      private $callable;
      private $data;

      public function __construct($callable, $data) {
          $this->callable = $callable;
          $this->data = $data;
      }
  }
}

namespace React\EventLoop
{
    class ExtEvLoop
    {
        private $timers;

        public function __construct($timers) {
            $this->timers = $timers;
        }
    }

    /*
     * This sort of works, but the payload uses the new class name.
    class_alias(ExtEvLoop::class, 'RectorPrefix202411\React\EventLoop\ExtEvLoop');
    class_alias(ExtEvLoop::class, 'RectorPrefix202505\React\EventLoop\ExtEvLoop');
    */
}

namespace RectorPrefix202411\React\EventLoop {
    class ExtEvLoop
    {
        private $timers;

        public function __construct($timers)
        {
            $this->timers = $timers;
        }
    }
}

namespace RectorPrefix202505\React\EventLoop {
    class ExtEvLoop
    {
        private $timers;

        public function __construct($timers)
        {
            $this->timers = $timers;
        }
    }
}
