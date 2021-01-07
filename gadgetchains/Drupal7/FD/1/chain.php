<?php

namespace GadgetChain\Drupal7;

class FD1 extends \PHPGGC\GadgetChain\FileDelete
{
    public static $version = '7.0 < ?';
    public static $vector = '__destruct';
    public static $author = 'rreiss';
    public static $information = '
        Note that some files may not be removed (depends on permissions)
    ';

    public function generate(array $parameters)
    {
        return new \Archive_Tar($parameters['remote_file']);
    }
}
