<?php

namespace Principal\Model\Entity;

use Zend\Db\Sql\Where;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\I18n\View\Helper\DateFormat;
use Zend\Db\Sql\Select;

class Cupon extends TableGateway {

	
	public function __construct(Adapter $adapter = NULL, $databaseSchema = NULL, ResultSet
			$selectResultPrototype = NULL){
			
		return parent::__construct('cuponera', $adapter, $databaseSchema, $selectResultPrototype);
	
	}

	public function getCupones(){
		$resultSet = $this->select(function (Select $select) {
			$select->where(array(
				'activo' =>'si'
				));
			$select->limit(2);
		});
		return $resultSet;
	}

	public function getCuponesCat($idCat){
		$resultSet = $this->select(function (Select $select) use ($idCat){
			$select->where(array(
				'cat_id'=>$idCat,
				'activo' =>'si'
				));
			$select->limit(2);
		});
		return $resultSet;
	}
}
