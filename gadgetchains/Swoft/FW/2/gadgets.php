<?php

namespace Monolog\Handler
{
    class SyslogUdpHandler
    {
        protected $socket;

        function __construct($path, $data)
        {
            $this->socket = new \Swoft\Cache\Adapter\FileAdapter($path, $data);
        }
    }
}

namespace Swoft\Cache\Adapter
{
    class ArrayAdapter
    {
        private $data;
        
        function __construct($data)
        {
            $this->data = [$data];
        }
    }

    class FileAdapter extends ArrayAdapter
    {
        protected $dataFile;
        private $serializer;

        function __construct($path, $data)
        {
            $this->dataFile = $path;
            parent::__construct($data);
            $this->serializer = new \Swoft\Serialize\PhpSerializer();
        }
    }
}

namespace Swoft\Serialize
{
    class PhpSerializer
    {
        function __construct()
        {
        }
    }
}