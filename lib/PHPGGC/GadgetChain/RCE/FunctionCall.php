<?php

namespace PHPGGC\GadgetChain\RCE;

/**
 * Class FunctionCall
 * Executes a PHP function with one argument.
 * @package PHPGGC\GadgetChain\RCE
 */
abstract class FunctionCall extends \PHPGGC\GadgetChain\RCE
{
    public static $type = self::TYPE_RCE_FUNCTIONCALL;
    public static $parameters = [
        'function',
        'parameter'
    ];
}