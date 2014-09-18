<?php

namespace Comisionista\Model\Entity;

use Zend\Db\Sql\Where;

use Zend\Db\ResultSet\ResultSet;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\I18n\View\Helper\DateFormat;

class Empresa extends TableGateway 
{
	public function __construct(Adapter $adapter = NULL, $databaseSchema = NULL, ResultSet
			$selectResultPrototype = NULL){
			
			return parent::__construct('empresa', $adapter, $databaseSchema, $selectResultPrototype);
		
	}
	
	public function getEmpresas()
	{
		$resultSet = $this->select();
		return $resultSet->toArray();
	}
	
	public function getId($id){
		$id = (int) $id;
		$registros = $this->select(array(
				'id'=>$id
				));
		$registro=$registros->current();
		
		if(!$registro){
			
			throw new \Exception("No existe registro con el id: $id");
		}
		return $registro;
	}
	
	public function addPyme($data=array()){	
		$this->insert($data);
	}
	public function deletePyme($id){
		$this->delete(array(
				'id'=>$id
				));
	}


	public function updatePyme($id, $data=array())
	{
	
		$this->update($data, array('id' => $id));
	}
	
	public function getPymesComisionista($id_comisionista){
		$id_comisionista = (int) $id_comisionista;
		$registros = $this->select(array(
				'id_comisionista'=>$id_comisionista
				));
		return $registros->toArray();
	}
	
}