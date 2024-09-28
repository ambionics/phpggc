<?php

namespace PHPGGC\Enhancement;

/**
* Public Properties
* Attempts to convert references to protected or private properties within the
* serialized payload to public.
*
* This can be useful because when PHP serializes a non-public property of an
* object it prepends the property name with an asterisk (for protected) or the
* class name (for private) surrounded by null bytes, which are easy to lose if
* the payload is transmitted or stored as plain text without encoding. If that
* happens, the payload will fail to unserialize because the string length of the
* property name (and the name itself) will be incorrect.
*
* As an added bonus, payloads are slightly smaller without the prefixes.
*
* Converting properties to public tends to work in more recent PHP versions but
* can cause problems in older versions (before PHP 7.2).
*
* This functionality may not work properly if a chain includes one or more
* objects that have a custom serialize / unserialize implementation.
*/
class PublicProperties extends Enhancement
{

    /**
     * Post process step of the public-attributes technique: removes prefixes
     * denoting protected properties, converting them to public.
     */
    public function process_serialized($serialized)
    {
       // Encode the payload to make null bytes easier to work with.
       $encoded_payload = urlencode($serialized);
       preg_match_all('/s%3A([0-9]*)%3A%22%00(([[:alnum:]_]|%2A)*)%00/', $encoded_payload, $matches);
       $replace_pairs = [];
       if (count($matches[1]) > 0) {
           foreach ($matches[1] as $i => $length) {
               $search = 's%3A' . $length . '%3A%22%00' . $matches[2][$i] . '%00';
               $reduction = strlen(urldecode($matches[2][$i])) + 2;
               $replace = 's%3A' . $length - $reduction . '%3A%22';
               $replace_pairs[$search] = $replace;
           }
           $encoded_payload = strtr($encoded_payload, $replace_pairs);
       }
       return urldecode($encoded_payload);
    }
}
