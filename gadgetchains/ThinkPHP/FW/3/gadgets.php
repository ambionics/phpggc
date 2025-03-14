<?php

namespace League\Flysystem\Cached\Storage
{
    class Adapter
    {
        protected $autosave=false;
        protected $cache=[];
        protected $file;
        protected $complete;
        protected $adapter;

        function __construct($remote_path, $data)
        {
            $this->file = $remote_path;
            $this->complete = $data;
            $this->adapter = new \League\Flysystem\Adapter\Local();
        }
    }
}

namespace League\Flysystem\Adapter
{
    class Local
    {
        protected $pathPrefix='';
        protected $writeFlags=0;

        function __construct()
        {
        }
    }
}