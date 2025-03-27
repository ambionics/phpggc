<?php

namespace PHPGGC\GadgetChain;

abstract class AccountTakeover extends \PHPGGC\GadgetChain
{
    public static $type = 'AT';
    public static $type_description = 'Account takeover';

    public static $parameters = [
        'mail'
    ];

    public function test_setup()
    {
        throw new \PHPGGC\Exception("Account takeover payloads cannot be tested.");
    }

    public function test_confirm($arguments, $output)
    {
        return false;
    }
}
