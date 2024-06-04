<?php

namespace Swoft\Session
{
    class SwooleStorage
    {
        private $db;

        function __construct($path)
        {
            $this->db = new \Swoft\Http\Session\HttpSession($path);
        }
    }
}

namespace Swoft\Http\Session
{
    class HttpSession
    {
        private $handler;
        private $sessionId;

        function __construct($path)
        {
            $parts = explode('/',$path);
            $this->sessionId = array_pop($parts);
            $prePath = implode('/',$parts);
            $this->handler = new \Swoft\Http\Session\Handler\FileHandler($prePath);
        }
    }
}

namespace Swoft\Http\Session\Handler
{
    class FileHandler
    {
        private $savePath;
        protected $prefix='';

        function __construct($path)
        {
            $this->savePath = $path;
        }
    }
}