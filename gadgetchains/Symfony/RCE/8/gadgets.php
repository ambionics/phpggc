<?php

namespace Symfony\Component\Routing
{
    class Router
    {
        protected $matcher;
        protected $context;
        protected $collection;
        protected $options = [
            'matcher_class' => ':)',
            'cache_dir' => null
        ];

        function __construct($class, $collection, $context)
        {
            $this->matcher = null;
            $this->options["matcher_class"] = $class;
            $this->collection = $collection;
            $this->context = $context;
        }
    }
}

namespace Symfony\Component\DependencyInjection\Argument
{
    class RewindableGenerator
    {
        private $generator;

        public function __construct($generator)
        {
            $this->generator = $generator;
        }
    }
}

namespace Symfony\Component\DependencyInjection\Loader\Configurator
{
    abstract class AbstractServiceConfigurator
    {
        private $defaultTags;

        public function __construct($defaultTags)
        {
            $this->defaultTags = $defaultTags;
        }
    }

    class AliasConfigurator extends AbstractServiceConfigurator
    {
    
    }
}
