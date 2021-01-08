<?php

namespace PHPGGC\Enhancement;

/**
 * ASCII Strings
 * Uses the "S" serialization format instead of the standard "s". This
 * replaces every non-ASCII value to an hexadecimal representation:
 * s:5:"A<null_byte>B<cr><lf>"; -> S:5:"A\00B\09\0D";
 * This is experimental and it might not work in some cases.
 */
class ASCIIStrings extends Enhancement
{
    public function process_serialized($serialized)
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
            $clean_string = '';
            for($i=0; $i < strlen($string); $i++)
            {
                $letter = $string[$i];
                $clean_string .= ctype_print($letter) && $letter != '\\' ?
                    $letter :
                    sprintf("\\%02x", ord($letter));
                ;
            }

            # Make the replacement
            $new .= 
                substr($serialized, $last, $p_start - $last) .
                'S:' . $matches[1][0] . ':"' . $clean_string . '";'
            ;
            $last = $p_end_string + 2;
            $current = $last;
        }

        $new .= substr($serialized, $last);
        return $new;
    }
}