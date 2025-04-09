<?php

class ThemeRegistry
{
    protected $keysToPersist;

    public function __construct($keysToPersist)
    {
        $this->keysToPersist = $keysToPersist;
    }
}

class DatabaseStatementPrefetch
{
    protected $currentRow = [];
    protected $fetchStyle = 8; // PDO::FETCH_CLASS
    protected $fetchOptions = [];

    function __construct($class, $constructor_args)
    {
        $this->fetchOptions['class'] = $class;
        $this->fetchOptions['constructor_args'] = $constructor_args;
    }
}
