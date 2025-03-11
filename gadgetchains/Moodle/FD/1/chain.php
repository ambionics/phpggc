<?php

namespace GadgetChain\Moodle;

class FD1 extends \PHPGGC\GadgetChain\FileDelete
{
    public static $version = '2.4.0 <= 4.5.0+';
    public static $vector = '__destruct';
    public static $author = 'mcdruid';
    public static $information = 'Moodle\'s class loading is "quirky" so classes
    are not always available.';

    public function generate(array $parameters)
    {
        return new \cachelock_file($parameters['remote_path']);
    }
}
