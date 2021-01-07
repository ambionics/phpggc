<?php

namespace PHPGGC\GadgetChain;

abstract class RCE extends \PHPGGC\GadgetChain
{
    public static $type = self::TYPE_RCE;
    # TBD by subclasses
    public static $parameters = [];
}