<?php

namespace Drupal\views {
    class ViewExecutable
    {
           protected $serializationData = [
               'executed' => TRUE,
               'storage' => 'frontpage',
               'current_display' => 'default',
               'args' => [],
               'current_page' => '',
               'exposed_input' => '',
               'exposed_data' => '',
               'exposed_raw_input' => '',
               'dom_id' => '',
           ];
           public $built = TRUE;
           public $live_preview = TRUE;
           public $query;
           public $displayHandlers;
           public $display_handler;

           function __construct($query, $displayHandlers, $display_handler) {
               $this->query = $query;
               $this->displayHandlers = $displayHandlers;
               $this->display_handler = $display_handler;
           }
    }

    class DisplayPluginCollection
    {

    }
}

namespace Drupal\views\Plugin\views\display {
    class DefaultDisplay
    {

    }
}

namespace Drupal\Core\Database\Query {
    class Update {
        protected $connectionTarget = 'default';
        protected $connectionKey = 'default';
        protected $queryOptions = [];
        protected $uniqueIdentifier;
        protected $nextPlaceholder = 0;
        protected $table = 'users_field_data';
        protected $fields;
        protected $condition;

        function __construct($fields, $condition) {
            $this->fields = $fields;
            $this->condition = $condition;
            // @see \Drupal\Core\Database\Query\Query::__construct
            $this->uniqueIdentifier = uniqid('', TRUE);
        }
    }

    class Condition
    {
        protected $conditions;
        protected $arguments = [];
        protected $changed = TRUE;
        protected $queryPlaceholderIdentifier = NULL;
        protected $stringVersion = NULL; // can we use this?

        function __construct($conditions)
        {
            $this->conditions = $conditions;
        }
    }
}
