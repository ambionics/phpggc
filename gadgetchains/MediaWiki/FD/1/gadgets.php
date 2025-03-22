<?php

namespace Wikimedia\FileBackend\FSFile {
    class TempFSFile {
        /** @var bool Garbage collect the temp file */
        protected $canDelete = TRUE;
        
        /** @var string Path to file */
        protected $path;        
        
        function __construct($path)
        {
            $this->path = $path;
        }
    }
}

/* This is the RCE which is already protected.. when did they add that? */
namespace Wikimedia {
    class ScopedCallback
    {
        protected $callback;
        protected $params;

        function __construct($callback, $params)
        {
            $this->callback = $callback;
            $this->params = $params;
        }
    }
}
