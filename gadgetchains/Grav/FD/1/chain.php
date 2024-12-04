<?php

namespace GadgetChain\Grav;

class FD1 extends \PHPGGC\GadgetChain\FileDelete
{
    public static $version = '1.4.0 <= 1.7.48+';
    public static $vector = '__destruct';
    public static $author = 'mcdruid';
    public static $information = 'https://github.com/getgrav/grav/pull/3874';

    public function generate(array $parameters)
    {
        return new \Grav\Framework\Cache\Adapter\FileCache($parameters['remote_path']);
    }
}
