<?php

namespace Principal\Model\Entity;


use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Select;

class Banner extends TableGateway {
	
	private $id;
	private $Nombre;
	private $web;
	private $nombre_imagen;
	private $tipo;
	private $id_empresa;
	private $categorias_disp;


	public function __construct(Adapter $adapter = NULL, $databaseSchema = NULL, ResultSet
			$selectResultPrototype = NULL){
			
		return parent::__construct('anuncios', $adapter, $databaseSchema, $selectResultPrototype);
	
	}

	public function getBannerCat($categoria){
		$resultSet = $this->select(function (Select $select) use ($categoria) {
			$select->where(array('idcategoria'=>$categoria));
			$select->limit(1);
			});
		return $resultSet;
	}

	public function getBaner240(){
		$resultSet = $this->select(array(
				'idcategoria'=>null,'tipo'=>'T260',
				));
		return $resultSet->toArray();
	}
	public function getBaner260Pyme($id_pyme){
		$resultSet = $this->select(array(
				'tipo'=>'T260',
				'id_empresa'=>$id_pyme
		));
		return $resultSet->toArray();
	}
	public function add($data=array()){
		$this->insert($data);
	}
	public function updateBanner($id, $data=array())
	{
		$this->update($data, array('id' => $id));
	}
	public function getBaner728($idcategoria){
		$resultSet = $this->select( function (Select $select) use ($idcategoria){
			$select->where("tipo='B728'");
			$select->where("idcategoria=>'$idcategoria'");
		});

		return $resultSet->toArray();
	}

}