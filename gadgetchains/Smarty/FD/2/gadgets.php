<?php

namespace Smarty\Cacheresource
{
    abstract class Base
    {
    }

    class File
    {
    }
}

namespace Smarty\Template
{
    abstract class GeneratedPhpFile
    {
    }

    class Cached extends GeneratedPhpFile
    {
    }

    class Source 
    {
    }
}

namespace Smarty
{
    class Data
    {
    }

    abstract class TemplateBase extends Data
    {
    }

    class Smarty extends TemplateBase
    {
    }

    class Template extends TemplateBase 
    {
        private $source;
        private $cached;
        protected $smarty;

        public function __construct($lock_id) {
            $this->smarty = new Smarty();
            $this->smarty->cache_locking = true;
            $this->getCached($lock_id);
        }

        public function getCached($lock_id) {
            $this->source = new \Smarty\Template\Source();
            $this->cached = new \Smarty\Template\Cached();
            $this->cached->source = $this->source;
            $this->cached->handler = new \Smarty\Cacheresource\File();
            $this->cached->lock_id = $lock_id;
            $this->cached->is_locked = true;
        }
    }
}

?>
