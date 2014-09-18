<?php 
namespace Micrositio\Model\Entity;

use Zend\Db\Sql\Where;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\I18n\View\Helper\DateFormat;
use Zend\Db\Sql\Select;

class Comentarios extends TableGateway {
  public function __construct(Adapter $adapter = NULL, $databaseSchema = NULL, ResultSet
      $selectResultPrototype = NULL){
      
      return parent::__construct('comentario', $adapter, $databaseSchema, $selectResultPrototype);
    
  }

  public function getComentarios ($id_empresa){
 $resultSet = $this->select(function (Select $select) use ($id_empresa) {
			$select->where(array(
				'id_pyme'=>$id_empresa
				));
			$select->limit(20);
		});
		return $resultSet;
  }
}
