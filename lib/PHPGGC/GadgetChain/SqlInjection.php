<?php

namespace PHPGGC\GadgetChain;

abstract class SqlInjection extends \PHPGGC\GadgetChain
{
    public $type = self::TYPE_SQL_INJECTION;
    public $parameters = [
        'sql'
    ];
}
