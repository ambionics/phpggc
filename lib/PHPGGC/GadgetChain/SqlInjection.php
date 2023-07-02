<?php

namespace PHPGGC\GadgetChain;

abstract class SqlInjection extends \PHPGGC\GadgetChain
{
    public static $type = 'SQLI';
    public static $type_description = 'SQL injection';

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
