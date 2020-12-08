<?php

namespace PHPGGC\GadgetChain;

abstract class Command extends \PHPGGC\GadgetChain
{
    public static $type = self::TYPE_CMD;
    public static $parameters = [
        'command'
    ];
}
