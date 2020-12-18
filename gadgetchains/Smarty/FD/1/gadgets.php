<?php

abstract class Smarty_CacheResource
{
}

class Smarty_Internal_CacheResource_File extends Smarty_CacheResource
{
    public function releaseLock(Smarty $smarty, Smarty_Template_Cached $cached)
    {
        $cached->is_locked = false;
        unlink($cached->lock_id);
    }
}

class Smarty_Template_Cached
{
    public $lock_id = null;
    public $is_locked = true;

    public function __construct()
    {
        $this->handler = new Smarty_Internal_CacheResource_File();
        $this->lock_id = '';
    }

    public function setlock($lock_id){
        if($lock_id){
            $this->lock_id = $lock_id;
        }
    }
}

class Smarty_Internal_TemplateBase
{
}

class Smarty extends Smarty_Internal_TemplateBase
{
    public $cache_locking = true;
    public $cache_dir;
    public $use_sub_dirs;
    public function __construct(){
        $this->cache_locking = 1;
        $this->cache_dir = "/";
        $this->use_sub_dirs = true;
        $this->cache = true;
    }
}

class Smarty_Internal_Template extends Smarty_Internal_TemplateBase
{

    public $cached;
    public $smarty;

    public function __construct($lock_id){
        $this->smarty = new Smarty();
        $this->cached = new Smarty_Template_Cached();
        $this->setlock($lock_id);
    }

    public function setlock($lock_id){
        $this->cached->setlock($lock_id);
    }

}

?>
