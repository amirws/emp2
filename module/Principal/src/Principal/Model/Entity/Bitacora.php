<?php

namespace Principal\Model\Entity;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Insert;


class Bitacora extends TableGateway{
	public function __construct(Adapter $adapter=null, $databaseSchema = null,
	 ResultSet $selectResultPrototype=null){
			
			return parent::__construct('bitacora', $adapter, $databaseSchema, $selectResultPrototype);
	}

	public function insertar($data=array()){
		$this->insert($data);
	}
}