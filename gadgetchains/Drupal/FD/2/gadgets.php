<?php

namespace Drupal\ai_automators\PluginBaseClasses {
    class VideoToText
    {
        public string $tmpDir;

        public function __construct($tmpDir)
        {
            $this->tmpDir = $tmpDir;
        }
    }
}
