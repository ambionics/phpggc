<?php

namespace Symfony\Component\String
{
    class UnicodeString
    {
        public $string;

        public function __construct($string)
        {
            $this->string = $string;
        }
    }
}

namespace Illuminate\Validation\Rules
{
    class ProhibitedIf
    {
        public $condition;

        public function __construct($condition)
        {
            $this->condition = $condition;
        }
    }
}

namespace Laravel\SerializableClosure
{
    class UnsignedSerializableClosure
    {
        public $serializable;

        public function __construct($serializable)
        {
            $this->serializable = $serializable;
        }
    }
}

namespace Laravel\SerializableClosure\Serializers
{
    class Native
    {
        public $code;

        public function __construct($code)
        {
            $this->code = $code;
        }

        public function __serialize()
        {
            return [
                'use' => [],
                'function' => 'static function () { ' . $this->code . ' }',
                'scope' => null,
                'this' => null,
                'self' => '00000000000000050000000000000000',
            ];
        }
    }
}
