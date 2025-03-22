<?php

namespace GadgetChain\MediaWiki;

class FW1 extends \PHPGGC\GadgetChain\FileWrite
{
    public static $version = '1.43.0+';
    public static $vector = '__destruct';
    public static $author = 'mcdruid';
    public static $information = '';

    public function generate(array $parameters)
    {
        return (
            new \JakubOnderka\PhpParallelLint\FileWriter(
                $parameters['remote_path'],
                $parameters['local_path'],
            )
        );
    }
}
