<?php

namespace PHPGGC\GadgetChain;

abstract class FileRead extends \PHPGGC\GadgetChain
{
	public $type = TYPE_FILE_READ;
	public $parameters = [
		'remote_file'
	];
}