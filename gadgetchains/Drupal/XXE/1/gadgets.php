<?php

namespace Drupal\Core {
    class Url
    {
        // use DependencySerializationTrait;
        protected $_serviceIds = [];
        public function __construct($serviceIds)
        {
            $this->_serviceIds = $serviceIds;
        }

    }
}

namespace Drupal\Core\Database {
    class StatementPrefetch
    {
        protected $currentRow = array();
        protected $fetchStyle = 8; // PDO::FETCH_CLASS
        protected $fetchOptions = array();

        function __construct($class, $constructor_args)
        {
            $this->fetchOptions['class'] = $class;
            $this->fetchOptions['constructor_args'] = $constructor_args;
        }
    }
}