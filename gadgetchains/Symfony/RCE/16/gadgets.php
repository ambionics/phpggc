<?php

class sfOutputEscaperArrayDecorator
{
    protected $value;

    protected $escapingMethod;

    public function __construct($escapingMethod, $value)
    {
        $this->escapingMethod = $escapingMethod;
        $this->value = $value;
    }
}

class sfNamespacedParameterHolder implements Serializable
{
    protected $prop = null;

    public function __construct($prop)
    {
        $this->prop = $prop;
    }

    public function serialize()
    {
        return serialize($this->prop);
    }

    public function unserialize($serialized)
    {
    }
}
