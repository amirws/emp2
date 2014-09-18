<?php

namespace Comisionista\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Comisionista\Model\Entity\Empresa;
use Comisionista\Model\Entity\Comisionista;
use Zend\Db\Adapter\Adapter;
use Zend\Session\Container;
use Comisionista\Form\Pyme;
use Comisionista\Form\LoginValidator;
use Comisionista\Model\Entity\LoginUser as LoginService;


class HomeController extends AbstractActionController {
public  $dbAdapter;	
private $login;

	public function indexAction(){
		
		$session = new Container('comisionista');
		$nom_comisionista = $session->comisionista->nombre;

		if ($nom_comisionista==''){
			$this->redirect()->toUrl($this->getRequest()->getBaseUrl().'/comisionista');
		}
		else {

		$this->dbAdapter=$this->getServiceLocator()->get('Zend\Db\Adapter');	
		$lista = new Empresa($this->dbAdapter);

		$datos=(array(
				'titulo'	=>	'Lista de Pymes',
				'empresas'	=> $lista->getPymesComisionista($session->comisionista->id),
				'nombre' => $nom_comisionista
					));
		$layout = new ViewModel($datos);
		$this->layout('layout/home-comisionistas');
		return $layout;
	}

	}
	public function cerrarAction(){
		session_destroy();
        return $this->forward()->dispatch('Comisionista\Controller\Index',array('action' => 'logout'));
	}
	public function addAction(){

		$session = new Container('comisionista');
		$nom_comisionista = $session->comisionista->nombre;

		if ($nom_comisionista==''){
			$this->redirect()->toUrl($this->getRequest()->getBaseUrl().'/comisionista');
		}
		
		else{

		$empresa = new Pyme('nueva');
		$layout = new ViewModel(array('form'=>$empresa, 'titulo'=>'Nueva '));
		$this->layout('layout/home-comisionistas');
		return $layout;

		}
	}



}
