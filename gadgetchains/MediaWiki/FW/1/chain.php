<?php

namespace GadgetChain\MediaWiki;

class FW1 extends \PHPGGC\GadgetChain\FileWrite
{
    public static $version = '1.25.0+';
    public static $vector = '__destruct';
    public static $author = 'mcdruid';
    public static $information = 'php-parallel-lint is a dev dependency of
    MediaWiki so should not be installed in Production, but might be.';

    public function generate(array $parameters)
    {
        return (
            new \JakubOnderka\PhpParallelLint\FileWriter(  // master branch
            // new \PHP_Parallel_Lint\PhpParallelLint\Writers\FileWriter(  // develop branch
                $parameters['remote_path'],
                $parameters['data'],
            )
        );
    }
}
