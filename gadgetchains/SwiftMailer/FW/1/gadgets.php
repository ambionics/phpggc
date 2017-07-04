<?php

class Swift_Mime_HeaderEncoder_Base64HeaderEncoder
{
}

class Swift_Mime_Grammar
{
}

class Swift_Mime_SimpleHeaderFactory
{
    private $_encoder;
    private $_paramEncoder;
    private $_grammar;

    function __construct()
    {
        $this->_encoder = new Swift_Mime_HeaderEncoder_Base64HeaderEncoder();
        $this->_paramEncoder = new Swift_Mime_HeaderEncoder_Base64HeaderEncoder();
        $this->_grammar = new Swift_Mime_Grammar();
    }
}

class Swift_Mime_SimpleHeaderSet
{
    private $_factory;

    function __construct()
    {
        $this->_factory = new Swift_Mime_SimpleHeaderFactory();
    }
}

class Swift_Mime_ContentEncoder_RawContentEncoder
{

}

class Swift_Mime_SimpleMimeEntity
{
    private $_headers;
    private $_body;
    private $_encoder;
    private $_cache;
    private $_cacheKey = 'something';

    function __construct($cache, $body)
    {
        $this->_cache = $cache;
        $this->_body = $body;
        $this->_encoder = new Swift_Mime_ContentEncoder_RawContentEncoder();
        $this->_headers = new Swift_Mime_SimpleHeaderSet();
    }
}

class Swift_Message extends Swift_Mime_SimpleMimeEntity
{
    private $headerSigners = [];
    private $bodySigners = [];
    private $savedMessage = [];

    function __construct($headerSigner, $cache, $body)
    {
        parent::__construct($cache, $body);
        $this->headerSigners = [$headerSigner];
    }
}

class Swift_Signers_DomainKeySigner
{
    protected $_privateKey = <<<EOF
-----BEGIN RSA PRIVATE KEY-----
MIICXQIBAAKBgQDRpx277bhMnUSga718Dd7P7ZA+23B8kBzqie3hFklaPFL8R18w
bVjHU4VHJq1SIrkbaX9MKnuAl4y9VSruQuJtjb9k1mk1CaWgESwK0ViOx9ugoI4B
cmEToyO/gCPKAkF69r7Lfy/M0VOxXH58QURCQU3dS3pm5SP8hhy/ag8fowIDAQAB
AoGATbKBcoRHKR2fsVQ8hR0e1jBUpPbuWTuPe9xiLGj2BlsU5ioNPQVJQZXSbuwG
j8oOj/opEzErVBzWK9TEdEiVYRhcyPc6awiIulZAp928TRsP0+ZjKOTXtgU40GNf
BqdaI8oMgSjeB3mbJP9S9ghVmOEN1AArOPBrWKyIEcDq/gECQQD5C0rb1lYqN7Om
yx6gYUXW91xs40PCtNI1EVtFVkVb4B3Dsz3tmi93NxgDK+fJLcid3Yx4PF0v1pm6
ysBU2vupAkEA14IrToWxTtzcPI9852TJ4A9IA93Y7AppmWzkxp0uPM0tmRIuOpK+
foLPtdLcXE7KAtHoHnccpGSQE33clb5wawJBAOYPHXcZd/2F+UqCZudnFHoxhcr8
4nKyUWE+iF70BByMW1KWeQXOIjzxwxfi7jq1NZdHu2Sy9q6jgt3AQI3iwQkCQCy0
gP1R+H0OjdU2QsfRfZswMFU1ARm98zfzgeW9l2jfezUEs3hNFp0xz5q9Oh8f7QH2
vzsKpHNptQWGF2sszS8CQQCMZbkmUguZhj72vvJ33bbugLtjv2AjTQxwAOAZZF+3
6P1HpTADFnZQZbGAmjJNT//JEHs6+TTbb1Wjj+mJHbmR
-----END RSA PRIVATE KEY-----
EOF;
    private $_bound;

    function __construct($_bound)
    {
        $this->_bound = [$_bound];
    }
}

class Swift_KeyCache_ArrayKeyCache
{
    private $_contents = [];
    private $_stream;

    function __construct($_stream)
    {
        $this->_stream = $_stream;
    }
}

class Swift_KeyCache_SimpleKeyCacheInputStream
{
    private $_keyCache;
    private $_nsKey = 'something';
    private $_itemKey = 'something';
    private $_writeThrough = null;

    function __construct($_writeThrough)
    {
        $this->_keyCache = new Swift_KeyCache_ArrayKeyCache(null);
        $this->_writeThrough = $_writeThrough;
    }
}

abstract class Swift_ByteStream_AbstractFilterableInputStream
{
}

class Swift_ByteStream_FileByteStream extends Swift_ByteStream_AbstractFilterableInputStream
{
    private $_path;
    private $_mode = 'w+b';

    function __construct($_path)
    {
        $this->_path = $_path;
    }
}