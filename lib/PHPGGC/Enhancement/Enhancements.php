<?php

namespace PHPGGC\Enhancement;

class Enhancements
{
    public function __construct($enhancements)
    {
        $this->enhancements = $enhancements;
    }

    /**
     * Calls method $method on every enhancement.
     */
    public function __call($method, $arguments)
    {
        $argument = $arguments[0];
        foreach($this->enhancements as $enhancement)
        {
            $argument = $enhancement->$method(
                $argument
            );
        }
        return $argument;
    }
}