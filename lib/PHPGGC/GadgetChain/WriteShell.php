<?php

namespace PHPGGC\GadgetChain;

abstract class WriteShell extends \PHPGGC\GadgetChain
{
    public static $type = self::TYPE_SHELL;

    public function test_setup()
    {
        return [];
    }

    public function test_confirm($arguments, $output)
    {
        return false;
    }
}