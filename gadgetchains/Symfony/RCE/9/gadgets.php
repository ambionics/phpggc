<?php

namespace Symfony\Component\Process\Pipes
{
    class WindowsPipes
    {
        private $fileHandles = [];

        function __construct($fileHandles)
        {
            $this->fileHandles = $fileHandles;
        }
    }
}

namespace Symfony\Component\Finder\Iterator
{
    class SortableIterator
    {
        private $iterator;
        private $sort;

        function __construct($iterator, $sort)
        {
            $this->iterator = $iterator;
            $this->sort = $sort;
        }
    }
}

namespace Symfony\Component\Console\Input
{
    class ArrayInput
    {
        private $parameters;

        function __construct($parameters)
        {
            $this->parameters = $parameters;
        }
    }
}
