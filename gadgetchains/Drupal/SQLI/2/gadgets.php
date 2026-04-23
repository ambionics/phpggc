<?php

namespace Drupal\views {
    class ViewExecutable {
        protected $serializationData = [
            'executed'          => true,
            'storage'           => 'content', 
            'current_display'   => 'default',
            'args'              => [],
            'current_page'      => '',
            'exposed_input'     => [],
            'exposed_data'      => [],
            'exposed_raw_input' => [],
            'dom_id'            => '',
        ];
        public $built = true;
        public $live_preview = true;
        public $query;
        public $pager;
        public $build_info;

        function __construct($query, $pager, $build_info) {
            $this->query = $query;
            $this->pager = $pager;
            $this->build_info = $build_info;
        }
    }
}


namespace Drupal\views\Plugin\views\pager {
    class None {
    }
}

namespace Drupal\views\Plugin\views\query {
    class Sql {
        private $options = [
            'disable_sql_rewrite' => 'TRUE' 
        ];
    }
}

namespace Drupal\Core\Database\Query {
    class Select {
        private $connectionTarget = 'default';
        private $connectionKey = 'default';
        private $queryOptions = [];
        private $uniqueIdentifier;
        private $nextPlaceholder = 0;
        private $condition;
        private $having;
        private $union = [];
        private $tables;
        private $fields = [];
        private $expressions;

        function __construct($condition, $having, $tables, $expressions){
            $this->uniqueIdentifier = uniqid('', true);
            $this->condition = $condition;
            $this->having = $having;
            $this->tables = $tables;
            $this->expressions= $expressions;
        }
    }

    class Condition {

        private $conditions;
        private $arguments = [];
        private $changed = true;
        private $queryPlaceholderIdentifier = null;
        private $stringVersion = null;

        public function __construct($conditions) {
            $this->conditions = $conditions;
        }

        public function goBlank() {
        unset($this->arguments, $this->changed, $this->queryPlaceholderIdentifier, $this->stringVersion);
        }  
    } 

}