<?php

namespace Usuario\Controller;

use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session as SessionStorage;
use Zend\Session\Container;
use Principal\Model\Entity\Categoria;



class NuevaController extends AbstractActionController {
	
	public function __construct(){
		$this->messenger = new \stdClass();
		$this->auth = new AuthenticationService();
	}
	
	public $dbAdapter;
	private $login;
	private $messenger;
	
	public function indexAction(){
		$layout=new ViewModel(array(
		'titulo'=>'Titulo pagina'));
		$this->layout('layout/nueva');
		return $layout;
	}
	public function basicoAction(){
		$identi=$this->auth->getStorage()->read();
		$this->dbAdapter=$this->getServiceLocator()->get('Zend\Db\Adapter');
		if($identi!=false && $identi!=null){	
		}
		else {
			$this->redirect()->toUrl($this->getRequest()->getBaseUrl().'/usuario/');
		}
		$id_paquete=1;
		$categorias= new Categoria($this->dbAdapter);
		$categorias=$categorias->getCategorias();
		$layout=new ViewModel(array(
				'titulo'=>'Nueva Pyme | Paquete Básico',
				'id_paquete'=>$id_paquete,
				'nombre'=>$identi->Nombre,
				'categorias'=>$categorias));
		$this->layout('layout/nueva');
		return $layout;
	}
	public function micrositiovalAction(){
		
		$mensaje='Válido';
		$layout=new ViewModel(array(
		'mensaje'=>$mensaje));
		$this->layout('layout/nueva');
		return $layout;
	}
	
	
}