<?php

namespace Principal\Model\Entity;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Select;

class Categoria extends TableGateway{
	
	public function __construct(Adapter $adapter = NULL, $databaseSchema = NULL, ResultSet
				$selectResultPrototype = NULL){
		return parent::__construct('categoria', $adapter, $databaseSchema, $selectResultPrototype);
	}
	
	public function getCategorias(){
		$resultSet = $this->select(function (Select $select) {
			$select->order('nombre_categoria ASC');
		});
		return $resultSet;
	}
	public function getCategoriasId($id_cat){
		$registros = $this->select(array(
			'idcategoria'=>$id_cat
			));
		foreach ($registros as $categoria){
			$nombrecat=$categoria['nombre_categoria'];
		}
		return $nombrecat;
	}

}