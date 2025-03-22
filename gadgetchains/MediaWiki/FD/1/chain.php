<?php

namespace GadgetChain\MediaWiki;

class FD1 extends \PHPGGC\GadgetChain\FileDelete
{
    public static $version = '1.43.0+';
    public static $vector = '__destruct';
    public static $author = 'mcdruid';
    public static $information = '';

    public function generate(array $parameters)
    {
        return (
            new \Wikimedia\FileBackend\FSFile\TempFSFile(
                $parameters['remote_path'],
            )
        );
    }
}
