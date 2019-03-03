<?php

namespace GadgetChain\Drupal7;

class FD1 extends \PHPGGC\GadgetChain\FileDelete
{
    public $version = '7.0 < ?';
    public $vector = '__destruct';
    public $author = 'rreiss';
    public $informations = 'Note that some files may not be removed (depends on the its permissions)';
    public $parameters = [
        'remote_file'
    ];

    public function generate(array $parameters)
    {
        return new \Archive_Tar($parameters['remote_file']);
    }
}
