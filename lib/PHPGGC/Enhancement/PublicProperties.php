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
       preg_match_all('/s:([0-9]*):"\x00(([[:alnum:]_]|\*)*)\x00/', $serialized, $matches);
       $replace_pairs = [];
       if (count($matches[1]) > 0) {
           foreach ($matches[1] as $i => $length) {
               $search = 's:' . $length . ':"' . chr(0) . $matches[2][$i] . chr(0);
               $reduction = strlen($matches[2][$i]) + 2;
               $replace = 's:' . $length - $reduction . ':"';
               $replace_pairs[$search] = $replace;
           }
           $serialized = strtr($serialized, $replace_pairs);
       }
       return $serialized;
    }
}
