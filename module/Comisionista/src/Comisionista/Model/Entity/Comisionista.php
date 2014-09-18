<?php

namespace Comisionista\Model\Entity;

use Zend\Db\Sql\Where;

use Zend\Db\ResultSet\ResultSet;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\I18n\View\Helper\DateFormat;

class Comisionista extends TableGateway 
{
  public function __construct(Adapter $adapter = NULL, $databaseSchema = NULL, ResultSet
      $selectResultPrototype = NULL){
      
      return parent::__construct('comisionista', $adapter, $databaseSchema, $selectResultPrototype);
    
  }
  
  public function getComisionistas()
  {
    $resultSet = $this->select();
    return $resultSet->toArray();
  }
  
  public function getIdComisionista($username){
    $username = $username;
    $registros = $this->select(array(
        'usr'=>$username
        ));
    $registro=$registros->current();
    return $registro;
  }
  
  public function addComisionista($data=array()){ 
    $this->insert($data);
  }

  
}