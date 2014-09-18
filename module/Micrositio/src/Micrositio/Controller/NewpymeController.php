<?php
namespace Micrositio\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Micrositio\Model\Entity\Usuario;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Sql;
use Zend\Db\Adapter\Adapter;
use Micrositio\Controller\BMEAPI; 
use Zend\Mail;
use Micrositio\Model\Entity\LoginUser as LoginService;

class NewpymeController extends AbstractActionController {
public $dbAdapter;
	public function indexAction(){
		
		$vista = new ViewModel();
		$this->layout('layout/simple');
		return  $vista;
	}

}