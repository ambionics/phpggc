<?php

namespace
{
    require_once(DIR_GADGETCHAINS . '/WordPress/generic/gadgets.php');
}

namespace GuzzleHttp\Cookie
{
    class SetCookie
    {
        private $data;

        public function __construct($data)
        {
            $this->data = $data;
        }

        /*
        public function __toString()
        {
            $str = $this->data['Name'] . '=' . $this->data['Value'] . '; ';
            foreach ($this->data as $k => $v) {
                if ($k !== 'Name' && $k !== 'Value' && $v !== null && $v !== false) {
                    if ($k === 'Expires') {
                        $str .= 'Expires=' . gmdate('D, d M Y H:i:s \G\M\T', $v) . '; ';
                    } else {
                        $str .= ($v === true ? $k : "{$k}={$v}") . '; ';
                    }
                }
            }
            return rtrim($str, '; ');
        }
        */
    }
}