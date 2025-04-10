<?php

namespace Pop\Mail\Transport\Smtp
{
    class EsmtpTransport
    {
        protected $started=true;
        private $handlers=[];
        protected $buffer;

        public function __construct($path, $data)
        {
            $this->buffer = new \Pop\Mail\Transport\Smtp\Stream\Byte\FileByteStream($path, $data);
        }
    }
}

namespace Pop\Mail\Transport\Smtp\Stream\Byte
{
    abstract class AbstractFilterableInputStream
    {
        private $writeBuffer;

        public function __construct($data)
        {
            $this->writeBuffer = $data;
        }
    }

    class FileByteStream extends AbstractFilterableInputStream
    {
        private $filters=[];
        private $path;
        private $mode='w';

        public function __construct($path, $data)
        {
            parent::__construct($data);
            $this->path = $path;
        }
    }
}