<?php

namespace Laravel\SerializableClosure\Serializers {
    class Native
    {
        public $code;

        public function __construct($code)
        {
            $this->code = $code;
        }

        // target: https://github.com/laravel/serializable-closure/blob/cb291e4c998ac50637c7eeb58189c14f5de5b9dd/src/Serializers/Native.php#L167-L205

        public function __serialize()
        {
            return [
                'use' => false,
                'function' => $this->code
            ];
        }
    }
}
