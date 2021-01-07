<?php

namespace PHPGGC\Enhancement;

/**
 * Adds a + (plus) symbol before every integer symbol of given type.
 * For instance, with 'Osi',
 * O:3:"Abc":1:{s:1:"x";i:3;} -> O:+3:"Abc":+1:{s:+1:"x";i:+3;}
 * With 's':
 * O:3:"Abc":1:{s:1:"x";i:3;} -> O:3:"Abc":1:{s:+1:"x";i:3;}
 *
 * Note: Since PHP 7.2, only i and d (float) types can be prefixed by
 * a plus sign.
 */
class PlusNumbers extends Enhancement
{
    private $types;

    public function __construct($types)
    {
        $this->types = $types;
    }

    public function process_serialized($serialized)
    {
        $types = preg_quote($this->types, '#');
        $serialized = preg_replace(
            '#\b([' . $types . ']):(\d+)([:;])#',
            '$1:+$2$3',
            $serialized
        );
        return $serialized;
    }
}