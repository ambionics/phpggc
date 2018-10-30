<?php

namespace GuzzleHttp\Psr7
{
    class FnStream
    {
        public $_fn_close;

        function __construct($cmd)
        {
            $this->_fn_close = $cmd;
        }
    }
}
