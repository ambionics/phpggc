<?php

namespace PHPGGC\Enhancement;

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
class FastDestruct extends Enhancement
{
    const FAST_DESTRUCT_TEMP_KEY = 7896543210;
    const FAST_DESTRUCT_FINAL_KEY = 7;

    /*
     * Pre-process step simply puts the object in an identifiable 2-elements
     * array.
     */
    public function process_object($object)
    {
        $key = self::FAST_DESTRUCT_TEMP_KEY;
        return [$key => $object, $key + 1 => $key];
    }

    /**
     * Post process step of the fast-destruct technique: replaces the original
     * array with an array with the two same keys.
     */
    public function process_serialized($serialized)
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
}