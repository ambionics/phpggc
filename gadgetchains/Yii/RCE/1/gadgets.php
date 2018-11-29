<?php

class CMapIterator
{
    private $_d;
    private $_keys = [0];
    private $_key = 0;

    function __construct($_d)
    {
        $this->_d = $_d;
    }
}

class CDbCriteria
{
    function __construct($params)
    {
        $this->params = $params;
    }
}

class CFileCache
{
    public $keyPrefix = '';
    public $hashKey = false;
    public $serializer;

    public $cachePath = 'data:text/';
    public $directoryLevel = 0;
    public $embedExpiry = true;
    public $cacheFileSuffix;

    function __construct($function, $cacheFileSuffix)
    {
        $this->serializer = [1 => $function];
        $this->cacheFileSuffix = ';base64,' . $cacheFileSuffix;
    }
}