<?php

namespace think\model\concern
{
    trait Attribute
    {
        private $data;
        private $withAttr;
        protected $json;
        protected $jsonAssoc;
    }
    trait ModelEvent
    {
        protected $withEvent;
    }
}

namespace think
{
    abstract class Model
    {
        use \think\model\concern\Attribute;
        use \think\model\concern\ModelEvent;

        private $exists;
        private $force;
        private $lazySave;
        protected $suffix;
        private $data;
        private $withAttr;
        protected $json;
        protected $jsonAssoc;

        function __construct($i, $func, $param)
        {
            $this->data = ["key" => ["key" => $param]];
            
            if ($i == 0) {
                $this->exists = true;
                $this->force = true;
                $this->lazySave = true;
                $this->withEvent = false;
                $this->suffix = new \think\model\Pivot(1, $func, $param);
            } else {
                $this->jsonAssoc = true;
                $this->withAttr = ["key" => ["key" => $func]];
                $this->json = ["key"];
            }
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
