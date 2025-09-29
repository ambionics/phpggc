<?php

namespace
{
    require_once(DIR_GADGETCHAINS . '/WordPress/generic/gadgets.php');
}

namespace GuzzleHttp\Psr7
{
    class AppendStream
    {
        private $seekable=true;
        private $streams;

        public function __construct($streams)
        {
            $this->streams = $streams;
        }
    }
}