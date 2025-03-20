<?php

namespace PHPGGC\GadgetChain\SQLI;

/**
 * Class MySQLAuthenticatedSQLI
 * Performs SQL injection with configurable database credentials
 * @package PHPGGC\GadgetChain\SQLI
 */
abstract class MySQLAuthenticatedSQLI extends \PHPGGC\GadgetChain\SqlInjection
{
    public static $type_description = 'MySQL Authenticated SQL injection';

    public static $parameters = [
        'sql',
        'host',
        'dbname',
        'username',
        'password'
    ];

    public function test_setup()
    {
        throw new \PHPGGC\Exception("SQL injection payloads cannot be tested.");
    }
} 