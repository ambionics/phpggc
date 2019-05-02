<?php

namespace PHPGGC\Enhancement;

abstract class Enhancement
{
	public function process_parameters($parameters)
	{
		return $parameters;
	}
	
	public function process_object($object)
	{
		return $object;
	}

	public function process_serialized($serialized)
	{
		return $serialized;
	}
}