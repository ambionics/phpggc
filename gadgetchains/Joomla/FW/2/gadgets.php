<?php

/*
 * Joomla file-write chain, independent of the FormattedtextLogger gadget used
 * by Joomla/FW/1 (which was neutralised in Joomla 5.2.2 by a __wakeup guard,
 * https://github.com/joomla/joomla-cms/pull/44428).
 *
 * Kickoff:  Joomla\Database\DatabaseDriver::__destruct()
 *             -> disconnect()  [safe no-op when connection & statement are null]
 *               -> dispatchEvent(new ConnectionEvent('onAfterDisconnect', $this))
 *                 -> $this->dispatcher->dispatch('onAfterDisconnect', $event)
 *
 * Pivot:    Joomla\Event\Dispatcher::dispatch()
 *             foreach ($this->listeners[$name] as $listener) $listener($event);
 *           $listeners is untyped, so a plain [ [Patcher, 'apply'] ] callable
 *           array is accepted (no ListenersPriorityQueue needed).
 *
 * Sink:     Joomla\Filesystem\Patcher::apply()
 *             foreach ($this->destinations as $file => $content)
 *               File::write($file, implode("\n", $content));
 *           sources / removals / patches are empty so only the write runs.
 *
 * MysqliDriver is used as the concrete driver because its disconnect() path is
 * a clean no-op with a null connection; PDO drivers are avoided as PdoDriver
 * defines a __wakeup() that interferes.
 */

namespace Joomla\Database
{
    // $dispatcher is a private property brought in via DispatcherAwareTrait,
    // which PHP mangles as private-owned-by-DatabaseDriver. Declaring it here
    // (with MysqliDriver extending this class) reproduces that exact name.
    class DatabaseDriver
    {
        private $dispatcher;
        protected $connection = null;
        protected $statement  = null;

        public function __construct($dispatcher)
        {
            $this->dispatcher = $dispatcher;
        }
    }
}

namespace Joomla\Database\Mysqli
{
    class MysqliDriver extends \Joomla\Database\DatabaseDriver
    {
    }
}

namespace Joomla\Event
{
    class Dispatcher
    {
        protected $events = [];
        protected $listeners;

        public function __construct($listener)
        {
            // ConnectionEvent name dispatched by DatabaseDriver::disconnect().
            $this->listeners = ['onAfterDisconnect' => [$listener]];
        }
    }
}

namespace Joomla\Filesystem
{
    class Patcher
    {
        protected $sources      = [];
        protected $destinations;
        protected $removals     = [];
        protected $patches      = [];

        public function __construct($path, $data)
        {
            // apply() does implode("\n", $content), so wrap content in an array.
            $this->destinations = [$path => [$data]];
        }
    }
}
