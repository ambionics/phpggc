<?php

namespace PHPGGC;

class Enhancements
{
    /**
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
    public static function fast_destruct($serialized)
    {
        $key = 7;

        $wrapped = sprintf('a:2:{i:%s;%si:%s;i:0;}', $key, $serialized, $key);

        // Serialized object was wrapped by an array.
        // All existing references must be increased by 1.
        // See: http://www.phpinternalsbook.com/classes_objects/serialization.html
        $wrapped = preg_replace_callback(
            '~(r|R):(\d+)~',
            function ($matches) {
                return sprintf('%s:%d', $matches[1], ++$matches[2]);
            },
            $wrapped
        );

        return $wrapped;
    }

    /**
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
