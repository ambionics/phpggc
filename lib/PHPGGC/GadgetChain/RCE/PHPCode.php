<?php

namespace PHPGGC\GadgetChain\RCE;

/**
 * Class PHPCode
 * Executes PHP code.
 * @package PHPGGC\GadgetChain\RCE
 */
abstract class PHPCode extends \PHPGGC\GadgetChain\RCE
{
    public static $type = self::TYPE_RCE_PHPCODE;
    public static $parameters = [
        'code'
    ];
}