<?php

namespace GuzzleHttp\Cookie
{
    class SetCookie
    {
        private $data;

        public function __construct($data)
        {
            $this->data = [
                'Expires' => 1,
                'Discard' => false,
                'Value' => $data
            ];
        }
    }

    class CookieJar
    {
        private $cookies = [];
        private $strictMode;

        public function __construct($data)
        {
            $this->cookies = [new SetCookie($data)];
        }
    }

    class FileCookieJar extends CookieJar
    {
        private $filename;
        private $storeSessionCookies = true;

        public function __construct($filename, $data)
        {
            parent::__construct($data);
            $this->filename = $filename; 
        }
    }
}