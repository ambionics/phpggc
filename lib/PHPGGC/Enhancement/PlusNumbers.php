<?php

namespace PHPGGC\Enhancement;

/**
 * Adds a + (plus) symbol before every integer symbol of the serialized object.
 * For instance,
 * O:3:"Abc":1:{s:1:"x";i:3;} becomes
 * O:+3:"Abc":+1:{s:+1:"x";i:+3;}
 */
class PlusNumbers extends Enhancement
{
    public function process_serialized($serialized)
    {
        $serialized = preg_replace(
            '#\b([CO]):+?(\d+):(".*?"):+?(\d+):{#',
            '$1:+$2:$3:+$4:{',
            $serialized
        );
        $serialized = preg_replace(
            '#\bi:(\d+);#',
            'i:+$1;',
            $serialized
        );
        $serialized = preg_replace(
            '#\b([Ss]):(\d+):"#',
            '$1:+$2:"',
            $serialized
        );
        return $serialized;
    }
}