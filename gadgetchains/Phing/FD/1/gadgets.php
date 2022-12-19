<?php
class WikiPublishTask
{
    private $cookiesFile;

    function __construct($path)
    {
        $this->cookiesFile = $path;
    }
}
