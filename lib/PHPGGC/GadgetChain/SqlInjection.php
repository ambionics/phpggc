<?php

namespace PHPGGC\GadgetChain;

abstract class SqlInjection extends \PHPGGC\GadgetChain
{
    public static $type = self::TYPE_SQLI;
    public static $parameters = [
        'sql'
    ];

    public function test_setup()
    {
        throw new \PHPGGC\Exception("SQL injection payloads cannot be tested.");
    }

    public function test_confirm($arguments, $output)
    {
        return false;
    }
}
