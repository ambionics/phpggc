<?php

namespace PHPGGC\GadgetChain;

abstract class SqlInjection extends \PHPGGC\GadgetChain
{
    public static $type = self::TYPE_SQLI;
    public static $parameters = [
        'sql'
    ];
}
