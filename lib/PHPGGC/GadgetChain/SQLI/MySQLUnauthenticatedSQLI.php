<?php

namespace PHPGGC\GadgetChain\SQLI;

/**
 * Class MySQLUnauthenticatedSQLI.php
 * Performs SQL injection without configurable database credentials
 * @package PHPGGC\GadgetChain\SQLI
 */
abstract class MySQLUnauthenticatedSQLI extends \PHPGGC\GadgetChain\SqlInjection
{
    public static $type_description = 'MySQL Unauthenticated SQL injection';

    public static $parameters = [
    ];

    public function test_setup()
    {
        throw new \PHPGGC\Exception("SQL injection payloads cannot be tested.");
    }
} 