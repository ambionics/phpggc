<?php

class Horde_Config
{
   protected $_oldConfig;
   function __construct($code)
   {
	   $this->_oldConfig = $code;
   }
}

class Horde_Prefs_Scope implements Serializable
{
    protected $_prefs = array(1);
    protected $scope;
    public function serialize()
    {
        return json_encode(array(
            $this->scope,
            $this->_prefs
        ));
    }

    public function unserialize($data)
    {
        list($this->scope, $this->_prefs) = json_decode($data, true);
    }
}

class Horde_Prefs
{
   protected $_opts, $_scopes;
   function __construct($code)
   {
      $this->_opts['sizecallback'] = array(new Horde_Config($code), 'readXMLConfig');
      $this->_scopes['horde'] = new Horde_Prefs_Scope;
   }
}

class Horde_Prefs_Identity
{
   protected $_prefs, $_prefnames, $_identities;
   function __construct($code)
   {
      $this->_identities = array(0);
      $this->_prefs = new Horde_Prefs($code);
      $this->_prefnames['identities'] = 0;
   }
}

class Horde_Kolab_Server_Decorator_Clean
{
   private $_server, $_added;
   function __construct($code)
   {
      $this->_added = array(0);
      $this->_server = new Horde_Prefs_Identity($code);
   }
}
?>
