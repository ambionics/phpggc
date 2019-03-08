<?php

namespace PHPGGC;

class Enhancements
{
    const FAST_DESTRUCT_TEMP_KEY = 7896543210;
    const FAST_DESTRUCT_FINAL_KEY = 7;

    /**
     * Fast Destruct
     * Applies the fast-destruct technique, so that the object is destroyed
     * right after the unserialize() call, as opposed to at the end of the
     * script.
     *
     * This is very useful because sometimes the script throws an exception
     * after unserializing the object, and therefore __destruct() will never be
     * called.
     *
     * The object is put in a 2-item array. Both items have the same key.
     * Since the object has been put first, it is removed when the second item
     * is processed (same key). It will therefore be destroyed, and as a result
     * __destruct() will be called right after the unserialize() call, instead
     * of at the end of the script.
     */

    /*
     * Pre-process step simply puts the object in an identifiable 2-elements
     * array.
     */
    public static function fast_destruct_process_object($object)
    {
        $key = self::FAST_DESTRUCT_TEMP_KEY;
        return [$key => $object, $key + 1 => $key];
    }

    /**
     * Post process step of the fast-destruct technique: replaces the original
     * array with an array with the two same keys.
     */
    public static function fast_destruct_process_serialized($serialized)
    {
        /*
        This replaces the whole array structure, but it could not work in some
        edge cases. The second technique is more permissive but should not cause
        problems.
        
        $find = (
            '#a:2:{' .
                'i:' . self::FAST_DESTRUCT_TEMP_KEY . ';' .
                '(.*?)' .
                'i:' . (self::FAST_DESTRUCT_TEMP_KEY + 1) . ';' .
                'i:' . self::FAST_DESTRUCT_TEMP_KEY . ';' .
            '}#s'
        );
        $replace = (
            'a:2:{' .
                'i:' . self::FAST_DESTRUCT_FINAL_KEY . ';' .
                '\1' .
                'i:' . self::FAST_DESTRUCT_FINAL_KEY . ';' .
                'i:' . self::FAST_DESTRUCT_FINAL_KEY . ';' .
            '}'
        );
        */
        $find = (
            '#i:(' .
                self::FAST_DESTRUCT_TEMP_KEY . '|' .
                (self::FAST_DESTRUCT_TEMP_KEY + 1) .
            ');#'
        );
        $replace = 'i:' . self::FAST_DESTRUCT_FINAL_KEY . ';';
        return preg_replace($find, $replace, $serialized);
    }

    /**
     * Wrapper
     * Includes a file and calls its process_parameters and process_serialized
     * methods.
     * This allows users to define custom actions so that the payload can be
     * formatted as they want it.
     */

    public static function wrapper_include($filename)
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

    protected static function _call_if_exists($function, $data)
    {
        if(function_exists($function))
            return call_user_func($function, $data);
        return $data;
    }

    public static function wrapper_process_parameters($parameters)
    {
        return static::_call_if_exists('process_parameters', $parameters);
    }

    public static function wrapper_process_object($payload)
    {
        return static::_call_if_exists('process_object', $payload);
    }

    public static function wrapper_process_serialized($serialized)
    {
        return static::_call_if_exists('process_serialized', $serialized);
    }

    /**
     * ASCII Strings
     * Uses the "S" serialization format instead of the standard "s". This
     * replaces every non-ASCII value to an hexadecimal representation:
     * s:5:"A<null_byte>B<cr><lf>"; -> S:5:"A\00B\09\0D";
     * This is experimental and it might not work in some cases.
     */
    public static function ascii_strings($serialized)
    {
        $new = '';
        $last = 0;
        $current = 0;
        $pattern = '#\bs:([0-9]+):"#';

        while(
            $current < strlen($serialized) &&
            preg_match(
                $pattern, $serialized, $matches, PREG_OFFSET_CAPTURE, $current
            )
        )
        {

            $p_start = $matches[0][1];
            $p_start_string = $p_start + strlen($matches[0][0]);
            $length = $matches[1][0];
            $p_end_string = $p_start_string + $length;

            # Check if this really is a serialized string
            if(!(
                strlen($serialized) > $p_end_string + 2 &&
                substr($serialized, $p_end_string, 2) == '";'
            ))
            {
                $current = $p_start_string;
                continue;
            }
            $string = substr($serialized, $p_start_string, $length);
            
            # Convert every special character to its S representation
            $string = preg_replace_callback(
                '#[^a-z0-9_\-:.=]#i', function($m) {
                    $value = str_pad(dechex(ord($m[0])), 2, '0', STR_PAD_LEFT);
                    return '\\' . $value;
                },
                $string
            );

            # Make the replacement
            $new .= 
                substr($serialized, $last, $p_start - $last) .
                'S:' . $matches[1][0] . ':"' . $string . '";'
            ;
            $last = $p_end_string + 2;
            $current = $last;
        }

        $new .= substr($serialized, $last);
        return $new;
    }
}