<?php

class Swift_KeyCache_DiskKeyCache
{
  private $_path;

  private $_keys = array();

  public function __construct($keys, $path) {
    $this->_keys = $keys;
    $this->_path = $path;
  }
}

class sfOutputEscaperArrayDecorator
{
  protected $value;

  protected $escapingMethod;

  public function __construct($escapingMethod, $value) {
    $this->escapingMethod = $escapingMethod;
    $this->value = $value;
  }
}