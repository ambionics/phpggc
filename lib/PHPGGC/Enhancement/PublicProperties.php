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
     * Post process step of the public-properties technique: removes prefixes
     * denoting protected or private properties, converting them to public.
     */
    public function process_serialized($serialized)
    {
        return preg_replace_callback('/\bs:(\d+):"\x00([\w\\\]+|\*)\x00/', [$this, 'remove_prefix'], $serialized);
    }

    public function remove_prefix($matches)
    {
        $length = $matches[1];
        $reduction = strlen($matches[2]) + 2; // prefix + 2 null bytes
        return 's:' . ($length - $reduction) . ':"';
    }
}
