<?php

class sfOutputEscaperArrayDecorator
{
  protected $value;

  protected $escapingMethod;

  public function __construct($escapingMethod, $value) {
    $this->escapingMethod = $escapingMethod;
    $this->value = $value;
  }
}

class MySQLiTableInfo 
{

  protected $name;
  protected $columns = array();
  protected $foreignKeys = array();
  protected $indexes = array();
  protected $primaryKey;
  protected $pkLoaded = false;
  protected $fksLoaded = false;
  protected $indexesLoaded = false;
  protected $colsLoaded = false;
  protected $vendorLoaded = false;
  protected $vendorSpecificInfo = array();
  protected $conn;
  protected $database;
  protected $dblink;
  protected $dbname;

  public function __construct($columns)
  {
    $this->columns = $columns;
  }
}