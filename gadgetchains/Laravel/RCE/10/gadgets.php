<?php

namespace Illuminate\Validation\Rules
{
    class RequiredIf
    {
        public function __construct($condition)
        {
            $this->condition = $condition;
        }
    }
}

namespace Illuminate\Auth
{
    class RequestGuard
    {
        public function __construct($callback, $request, $provider)
        {
            $this->callback = $callback;
            $this->request = $request;
            $this->provider = $provider;
        }
    }
}