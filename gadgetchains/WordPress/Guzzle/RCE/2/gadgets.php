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
class FileCookieJar
    {
        private $filename;

        public function __construct($cookieFile, $storeSessionCookies = \false)
        {
            $this->filename = $cookieFile;
        }

        /*
        
        public function __destruct()
        {
            $this->save($this->filename);
        }

        public function save($filename)
        {
            $json = [];
            foreach ($this as $cookie) {
                if (\GuzzleHttp\Cookie\CookieJar::shouldPersist($cookie, $this->storeSessionCookies)) {
                    $json[] = $cookie->toArray();
                }
            }
            $jsonStr = \GuzzleHttp\json_encode($json);
            if (\false === \file_put_contents($filename, $jsonStr)) {
                throw new \RuntimeException("Unable to save file {$filename}");
            }
        }

        */
    }

}