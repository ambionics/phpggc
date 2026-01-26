<?php

namespace GuzzleHttp\Cookie;

class SetCookie
{
    private $data = [];

    public function __construct(array $data = [])
    {
        static $defaults = [
            'Name' => null,
            'Value' => null,
            'Domain' => null,
            'Path' => '/',
            'Max-Age' => null,
            'Expires' => null,
            'Secure' => false,
            'Discard' => false,
            'HttpOnly' => false,
        ];
        $this->data = array_replace($defaults, $data);
    }
}

class CookieJar
{
    private $cookies = [];
    private $strictMode = false;

    public function setCookies(array $cookies)
    {
        $this->cookies = $cookies;
    }
}

class FileCookieJar extends CookieJar
{
    private $filename;
    private $storeSessionCookies = true;

    public function __construct(string $filename)
    {
        $this->filename = $filename;
    }
}
