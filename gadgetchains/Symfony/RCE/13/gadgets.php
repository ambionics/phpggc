<?php

class lime_test
{

  protected $output  = null;
  protected $results = array();
  protected $options = array();

  public $plan = null;
  public $test_nb = 1;
  public $failed = 1;
  public $passed = 0;
  public $skipped = 0;

  function __construct($output)
  {
    $this->output = $output;
  }
}

class lime_output_color
{
  public $colorizer = null;

  function __construct($colorizer)
  {
    $this->colorizer = $colorizer;
  }
}


class sfOutputEscaperObjectDecorator
{
  protected $value;

  protected $escapingMethod;

  public function __construct($escapingMethod, $value) {
    $this->escapingMethod = $escapingMethod;
    $this->value = $value;
  }
}

class lime_colorizer
{
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