<?php

namespace Wikimedia {
    class ScopedCallback
    {
        protected $callback;
        protected $params;

        function __construct($callback, $params)
        {
            $this->callback = $callback;
            $this->params = array($params);
        }
    }
}