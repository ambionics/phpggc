<?php

namespace PHPGGC\GadgetChain;

abstract class CMDInjection extends \PHPGGC\GadgetChain
{
    public static $type = self::TYPE_CMD;
    public static $parameters = [
        'command'
    ];
}
