<?php

namespace Pop\Mail\Transport\Smtp\Stream\Byte
{
    class FileByteStream
    {
        private $path;

        public function __construct($path)
        {
            $this->path = $path;
        }
    }
    class TemporaryFileByteStream extends FileByteStream
    {
        public function __construct($path)
        {
            parent::__construct($path);
        }
    }
}