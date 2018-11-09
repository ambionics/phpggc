<?php

namespace Symfony\Component\Cache\Traits
{
    use \Psr\Log\LoggerAwareTrait;

    trait AbstractTrait
    {
        use LoggerAwareTrait;

        private $namespace;
        private $deferred;
    }
}

namespace Psr\Log
{
    trait LoggerAwareTrait
    {
    }
}

namespace Symfony\Component\Cache\Adapter
{
    use \Symfony\Component\Cache\Traits\AbstractTrait;

    abstract class AbstractAdapter
    {
        use AbstractTrait;

        private $mergeByLifetime = 'proc_open';

        function __construct($command)
        {
            $this->deferred = $command;
            $this->namespace = [];
        }
    }

    class ApcuAdapter extends AbstractAdapter
    {
    }
}