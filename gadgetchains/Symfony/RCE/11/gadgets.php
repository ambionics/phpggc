<?php

namespace {
    require_once __DIR__ . "/../10/gadgets.php";
}

namespace Symfony\Component\Security\Core\Authentication\Token {
    class AnonymousToken implements \Serializable
    {
        public $parentData;

        public function __construct($parentData)
        {
            $this->parentData = $parentData;
        }

        public function serialize()
        {
            return serialize([null, $this->parentData]);
        }

        public function unserialize($serialized)
        {
        }
    }
}

namespace Symfony\Component\Validator {
    class ConstraintViolationList
    {
        private $violations;

        public function __construct($violations)
        {
            $this->violations = $violations;
        }
    }
}
