<?php

namespace PHPGGC\Enhancement;

/**
* Public Attributes
* Attempts to convert references to protected properties within the serialized
* payload to public.
*
* This can be useful because when PHP serializes a protected property of an
* object it prepends the property name with an asterisk surrounded by null
* bytes, which are easy to lose if the payload is transmitted or stored as plain
* text without encoding. If that happens, the payload will fail to unserialize
* because the string length of the property names will be incorrect.
*
* As an added bonus, payloads are slightly smaller without the prefixes.
*
* Converting protected properties to public tends to work in more recent PHP
* versions but can cause problems in older versions such as PHP 5.6.
*/
class PublicAttributes extends Enhancement
{

    /**
     * Post process step of the public-attributes technique: removes prefixes
     * denoting protected properties, converting them to public.
     */
    public function process_serialized($serialized)
    {
       $encoded_payload = urlencode($serialized);
       preg_match_all('/s%3A([0-9]*)%3A%22%00%2A%00/', $encoded_payload, $matches);
       $replace_pairs = [];
       if (is_array($matches[1])) {
           $lengths = array_unique($matches[1]);
           foreach ($lengths as $length) {
               $replace_pairs['s%3A' . $length . '%3A%22%00%2A%00'] = 's%3A' . $length - 3 . '%3A%22';
           }
       }
       $encoded_payload = strtr($encoded_payload, $replace_pairs);
       return urldecode($encoded_payload);
    }
}