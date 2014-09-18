<?php

namespace Micrositio\Model\Entity;

use Zend\Db\Sql\Where;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\I18n\View\Helper\DateFormat;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;

class Usuario extends TableGateway 
{
  public function __construct(Adapter $adapter = NULL, $databaseSchema = NULL, ResultSet
      $selectResultPrototype = NULL){
      
      return parent::__construct('usuario', $adapter, $databaseSchema, $selectResultPrototype);
    
  }
  
  public function getUsuarios() {
    $resultSet = $this->select();
    return $resultSet->toArray();
  }

  public function getUser ($id){
  $resultSet = $this->select(array(
			'id_usuario'=>$id));
  foreach ($resultSet as $result) {
    $nombre=$result['Nombre'];
  }
		return @$nombre;
  }
   public function getUserEmail($email){
    $resultSet = $this->select(function (Select $select) use ($email){
      $select->where(array(
        'email'=>$email,
        ));
      $select->limit(1);
    });
    return $resultSet->toArray();
  }
   public function SearchValidarUsuario($id, $codigo){
    $resultSet = $this->select(function (Select $select) use ($id, $codigo){
      $select->where(array('id_usuario'=>$id,'cod'=>$codigo));
    });
    return $resultSet->toArray();
  }

  public function addUser($datos=array()){
    $this->insert($datos);
}
public function validarEmail($email, $data=array()){
$this->update($data, array('email'=>$email));
}
public function getUserUsername ($username){
  $resultSet = $this->select(array(
      'us'=>$username));

    return @$resultSet;
  }
  public function actualizar($datos = array()){
    $this->update($datos);
  }


  
}