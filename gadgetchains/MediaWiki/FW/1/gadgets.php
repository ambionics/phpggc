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

/* pretty much exactly the same code in the develop branch:
https://github.com/php-parallel-lint/PHP-Parallel-Lint/blob/develop/src/Writers/FileWriter.php
*/
namespace PHP_Parallel_Lint\PhpParallelLint\Writers {
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
