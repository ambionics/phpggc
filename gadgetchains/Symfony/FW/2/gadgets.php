<?php

namespace Symfony\Bridge\PhpUnit\Legacy
{
	class SymfonyTestsListenerTrait
	{
		private static $globallyEnabled = false;
	    private $state = -1;
	    private $skippedFile = false;
	    private $wasSkipped = array();
	    private $isSkipped = array();
	    private $expectedDeprecations = array();
	    private $gatheredDeprecations = array();
	    private $previousErrorHandler;
	    private $testsWithWarnings;
	    private $reportUselessTests;
	    private $error;
	    private $runsInSeparateProcess = false;

	    public function __construct($path, $data)
	    {
            $this->state = 1;
        	$this->skippedFile = 'php://filter/convert.base64-decode/resource=' . $path;
        	$this->isSkipped = 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa' . base64_encode($data);
	    }
	}
}