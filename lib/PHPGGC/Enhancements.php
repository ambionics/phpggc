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
    public static function fast_destruct_pre($payload)
    {
        $key = self::FAST_DESTRUCT_TEMP_KEY;
        return [$key => $payload, $key + 1 => $key];
    }

    /**
     * Post process step of the fast-destruct technique: replaces the original
     * array with an array with the two same keys.
     */
    public static function fast_destruct_post($serialized)
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
     * Includes a file and calls its pre_process() and post_process() methods.
     * This allows users to define custom actions so that the payload can be
     * formatted as they want it.
     */

    public static function wrapper_inc($filename)
    {
        include $filename;

        if(
            !function_exists('pre_serialize') &&
            !function_exists('post_serialize')
        )
        {
            $message = (
                'Wrapper file does not define pre_serialize($payload) or ' .
                'post_serialize($serialized)'
            );
            throw new \PHPGGC\Exception($message);
        }
    }

    public static function wrapper_pre($payload)
    {
        if(function_exists('pre_serialize'))
            return call_user_func('pre_serialize', $payload);
        return $payload;
    }

    public static function wrapper_post($serialized)
    {
        if(function_exists('post_serialize'))
            return call_user_func('post_serialize', $serialized);
        return $serialized;
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