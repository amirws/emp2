<?php

namespace Usuario\Model;

use Zend\Db\Sql\Where;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\I18n\View\Helper\DateFormat;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;

class Orders extends TableGateway {
	
    public function __construct(Adapter $adapter = NULL, $databaseSchema = NULL, ResultSet
      $selectResultPrototype = NULL){
      
      return parent::__construct('orders', $adapter, $databaseSchema, $selectResultPrototype);
    
  }
	
	public function getOrderNull($id_user){
	$resultSet = $this->select(array(
			'id_user'=>$id_user,
			'id_pyme'=>null
			));
	return $resultSet;
	}
}
