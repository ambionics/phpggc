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
