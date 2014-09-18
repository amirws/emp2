<?php

namespace Usuario\Model;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;


class Municipio extends TableGateway {

	public function __construct(Adapter $adapter = NULL, $databaseSchema = NULL, ResultSet
			$selectResultPrototype = NULL){
		return parent::__construct('municipio', $adapter, $databaseSchema, $selectResultPrototype);
	}

	public function getMunicipios(){
		$resultSet = $this->select();
		return $resultSet;
	}
	public function getMunicipioUrl($url){
		$resultSet = $this->select(array(
				'url_m'=>$url));
		return $resultSet;
	}

}