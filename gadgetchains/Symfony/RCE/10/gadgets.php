<?php

namespace Symfony\Component\BrowserKit
{
    final class Response
    {
        private $headers;

        public function __construct($headers)
        {
            $this->headers = $headers;
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