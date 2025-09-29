<?php

namespace GadgetChain\Swoft;

class FD1 extends \PHPGGC\GadgetChain\FileDelete
{
    public static $version = '2.0.7 <= dev-master';
    public static $vector = '__destruct';
    public static $author = 'CyanM0un';

    public function generate(array $parameters)
    {
        return new \Swoft\Session\SwooleStorage($parameters['remote_path']);
    }
}