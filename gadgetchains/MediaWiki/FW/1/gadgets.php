<?php

namespace JakubOnderka\PhpParallelLint {
    class FileWriter {
        /** @var string */
        protected $logFile;

        /** @var string */
        protected $buffer;

        function __construct($logFile, $buffer)
        {
            $this->logFile = $logFile;
            $this->buffer = $buffer;
        }
    }
}

/* This is the RCE which is already protected.. when did they add that? */
namespace Wikimedia {
    class ScopedCallback
    {
        protected $callback;
        protected $params;

        function __construct($callback, $params)
        {
            $this->callback = $callback;
            $this->params = $params;
        }
    }
}
