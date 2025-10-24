<?php

namespace GadgetChain\FuelPHP;

class FD1 extends \PHPGGC\GadgetChain\FileDelete
{
    public static $version = '*';  // tested on 1.9-dev
    public static $vector = '__destruct';
    public static $author = 'reverseth';

    public function generate(array $parameters)
    {
        $file = $parameters['remote_path'];
        return new \Fuel\Core\Image_Imagemagick($file);

    }
}