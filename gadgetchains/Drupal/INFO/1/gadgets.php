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

namespace Psy {
    class ExecutionClosure {
        protected $closure;

        function __construct($closure) {
            $this->closure = $closure;
        }
    }
}
