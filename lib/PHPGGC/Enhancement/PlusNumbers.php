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