<?php
namespace PHPGGC\GadgetChain;

abstract class URI extends \PHPGGC\GadgetChain
{
    public static $type = self::TYPE_XXE;
    public static $parameters = [
        'xxe_uri'
    ];
}
?>
