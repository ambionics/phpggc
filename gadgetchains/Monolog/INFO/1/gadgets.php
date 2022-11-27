<?php
namespace GuzzleHttp\Stream{
    class FnStream{
        public $_fn_close;

        function __construct(){
            $this->_fn_close = 'phpinfo';
        }
    }
}
