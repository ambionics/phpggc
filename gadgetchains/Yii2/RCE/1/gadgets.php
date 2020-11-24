<?php

namespace yii\db {
    class ColumnSchemaBuilder {
        protected $type = 'x';
        public $categoryMap;

        function __construct($categoryMap) {
            $this->categoryMap = $categoryMap;
        }
    }

    class Connection {
        public $pdo = 1;

        function __construct($dsn) {
            $this->dsn = $dsn;
        }
    }

    class BatchQueryResult {
        private $_dataReader;

        function __construct($dataReader) {
            $this->_dataReader = $dataReader;
        }
    }
}

namespace yii\caching {
    class ArrayCache {
        public $serializer;
        private $_cache;

        function __construct($function, $parameter) {
            $this->serializer = [1 => $function];
            $this->_cache = ['x' => [$parameter, 0]];
        }
    }
}
