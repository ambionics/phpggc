<?php

namespace PHPGGC\GadgetChain;

abstract class RCE extends \PHPGGC\GadgetChain
{
    public static $type = self::TYPE_RCE;
    public $parameters = [
        'code'
    ];
}