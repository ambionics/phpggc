<?php
class PropelDateTime extends DateTime
{
  private $dateString;

	private $tzString;

  public function __construct($dateString, $tzString) {
    parent::__construct();
    $this->dateString = $dateString;
    $this->tzString = $tzString;
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

class sfCultureInfo
{
  protected $dataFileExt = '.dat';
  protected $data = array();
  protected $culture;
  protected $dataDir;
  protected $dataFiles = array();
  protected $dateTimeFormat;
  protected $numberFormat;
  protected $properties = array();

  public function __construct($culture) {
    $this->culture = $culture;
  }

}