<?php

class Swift_ByteStream_FileByteStream
{
    private $path;

    public function __construct($path)
    {
        $this->path = $path;
    }
}

class Swift_ByteStream_TemporaryFileByteStream extends Swift_ByteStream_FileByteStream
{
    public function __construct($path)
    {
        parent::__construct($path);
    }
}
