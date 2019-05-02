<?php

namespace PHPGGC\Enhancement;

/**
 * Wrapper
 * Includes a file and calls its process_parameters, process_object
 * and process_serialized methods, if they exist.
 * This allows users to define custom actions so that the payload can be
 * formatted as they want it.
 */
class Wrapper extends Enhancement
{
    public function __construct($filename)
    {
        require_once $filename;

        if(
            !function_exists('process_parameters') &&
            !function_exists('process_object') &&
            !function_exists('process_serialized')
        )
        {
            $message = (
                'Wrapper file does not define process_parameters(), ' .
                'process_object() or process_serialized()'
            );
            throw new \PHPGGC\Exception($message);
        }
    }

    private function _call_if_exists($function, $data)
    {
        if(function_exists($function))
            return call_user_func($function, $data);
        return $data;
    }

    public function process_parameters($parameters)
    {
        return $this->_call_if_exists('process_parameters', $parameters);
    }

    public function process_object($payload)
    {
        return $this->_call_if_exists('process_object', $payload);
    }

    public function process_serialized($serialized)
    {
        return $this->_call_if_exists('process_serialized', $serialized);
    }
}