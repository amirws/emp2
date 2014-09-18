<?php

namespace Principal\Model\Entity;

use Zend\Db\Sql\Where;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;

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
		return $registro;
	}
	public function getIdPyme($id){
$resultSet = $this->select (function ($select) use ($id) {
		$select->join('categoria', "empresa.idcategoria = categoria.idcategoria", array('nombre_categoria'), 'left');
		$select->where(array("id='$id'"));
		});
		return $resultSet->toArray();
	}
	public function addPyme($data=array()){	
		$this->insert($data);
	}

	public function updatePyme($id, $data=array())
	{
	
		$this->update($data, array('id' => $id));
	}
	
	public function deletePyme($id){
		$this->delete(array(
				'id'=>$id
				));
	}
	public function SearchUser($id_user){
		$id_user = (int) $id_user;
		$registros = $this->select(array(
			'id_usuario'=>$id_user
			));
		return $registros;
	}
	public function PymeUser($id_user, $id_pyme){
		$id_user = (int) $id_user;
		$id_pyme = (int) $id_pyme;
		$registros = $this->select(array(
				'id_usuario'=>$id_user,
				'id'=>$id_pyme
		));
		return $registros;
	}
	public function validarMicrositio(){
		$registros = $this->select();
	}


	
}