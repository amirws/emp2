<?php

namespace Usuario\Model;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;


class Bitacora extends TableGateway {

	public function __construct(Adapter $adapter = NULL, $databaseSchema = NULL, ResultSet
			$selectResultPrototype = NULL){
		return parent::__construct('bitacora', $adapter, $databaseSchema, $selectResultPrototype);
	}

	public function insertar($data=array()){
		$this->insert($data);
	}
}