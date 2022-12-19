<?php

class Swift_Mime_SimpleMimeEntity
{
    private $headers;
    private $body;
    private $cache;
    private $encoder;
    private $maxLineLength;
    private $cacheKey;

    public function __construct($path)
    {
        $this->headers = new Swift_Mime_Headers_OpenDKIMHeader();
        $this->body = new Swift_ByteStream_FileByteStream($path);
        $this->cache = new Swift_KeyCache_ArrayKeyCache();
        $this->encoder = new Swift_Mime_ContentEncoder_PlainContentEncoder();
        $this->cacheKey = "anykey";
        $this->maxLineLength = 100;
    }
}

class Swift_EmbeddedFile extends Swift_Mime_SimpleMimeEntity
{
    public function __construct($path)
    {
        parent::__construct($path);
    }
}

class Swift_Mime_Headers_OpenDKIMHeader
{
    private $fieldName;

    function __construct()
    {
        $this->fieldName = "any";
    }
}

class Swift_KeyCache_ArrayKeyCache
{
}

class Swift_Mime_ContentEncoder_PlainContentEncoder
{
    private $canonical = true;
}

class Swift_ByteStream_FileByteStream
{
    private $path;

    function __construct($path)
    {
        $this->path = $path;
    }
}
