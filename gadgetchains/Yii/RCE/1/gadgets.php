<?php

class CDbCriteria
{
    public $params;

    function __construct($params)
    {
        $this->params = $params;
    }
}

class CList
{
    /**
     * @var array internal data storage
     */
    private $_d;

    function __construct($_d)
    {
        $this->_d = $_d;
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