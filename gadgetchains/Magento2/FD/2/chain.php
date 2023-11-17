<?php

namespace GadgetChain\Magento2;

class FD2 extends \PHPGGC\GadgetChain\FileDelete
{
    public static $version = '*';
    public static $vector = '__destruct';
    public static $author = 'Maxime Rinaudo';
    public static $information = '';

    public function generate(array $parameters)
    {
        $file = $parameters['remote_path'];

        return new \Magento\RemoteStorage\Model\TmpFileCopier($file);
    }
}
