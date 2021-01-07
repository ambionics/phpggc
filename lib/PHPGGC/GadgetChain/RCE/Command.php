<?php

namespace PHPGGC\GadgetChain\RCE;

/**
 * Class Command
 * Executes a command (bash/batch).
 * @package PHPGGC\GadgetChain\RCE
 */
abstract class Command extends \PHPGGC\GadgetChain\RCE
{
    public static $type = self::TYPE_RCE_COMMAND;
    public static $parameters = [
        'command'
    ];
}