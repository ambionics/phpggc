<?php

namespace Keradus\CliExecutor
{
    class ScriptExecutor
    {
        private $tmpFilePath;

        function __construct($remote_path)
        {
            $this->tmpFilePath = $remote_path;
        }
    }
}