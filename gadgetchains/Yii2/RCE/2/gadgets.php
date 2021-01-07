<?php
namespace yii\web
{
    class DbSession
    {
        public $writeCallback;

        function __construct($writeCallback) {
            $this->writeCallback = $writeCallback;
        }
    }
}

namespace yii\caching
{
    class ExpressionDependency
    {
        public $expression;

        function __construct($expression) {
            $this->expression = $expression;
        }
    }
}

namespace yii\db {
    class BatchQueryResult {
        private $_dataReader;

        function __construct($dataReader) {
            $this->_dataReader = $dataReader;
        }
    }
}

?>
