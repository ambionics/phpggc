<?php

namespace Symfony\Component\Cache\Adapter
{
    class TagAwareAdapter
    {
        private $deferred;
        private $getTagsByKey;

        function __construct($function, $parameter)
        {
            $this->deferred = $parameter;
            $this->getTagsByKey = $function;
        }
    }
}
