<?php 

namespace Comisionista\Controller;

use Zend\Mvc\Controller\Plugin\Redirect;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Comisionista\Form\Login;
use Comisionista\Model\Entity\Comisionista;
use Comisionista\Model\Entity\Empresa;
use Zend\Db\Adapter\Adapter;
use Comisionista\Form\LoginValidator;
use Comisionista\Model\Entity\LoginUser as LoginService;
use Zend\Session\Container;


class IndexController extends AbstractActionController {

public  $dbAdapter;	
private $login;
private $messenger;

public function __construct(){
        $this->messenger = new \stdClass();
    }

	public function indexAction(){

		$formlogin = new Login('login');
		$this->dbAdapter=$this->getServiceLocator()->get('Zend\Db\Adapter');
		$this->login = new LoginService($this->dbAdapter, 'comisionista', 'usr', 'psw');
		$loggedIn = $this->login->isLoggedIn();
		
		$usuarioactual=$this->request->getPost('username');
		$usuariopassword=$this->request->getPost('password');
		$viewParams = new ViewModel(array('form' => $formlogin, 'loggedIn'=> $loggedIn, 'titulo'=> 'Login : Comisionistas', 'mensaje'=>@$this->messenger->message,'username'=>$usuarioactual, 'password'=>$usuariopassword));
		$this->layout('layout/comisionistas');
		$usuario=$this->login->getIdentity();
        if($loggedIn){
        	$session = new Container('comisionista');
			$session->comisionista=$usuario;
			$this->redirect()->toUrl($this->getRequest()->getBaseUrl().'/comisionista/home');
        }
        return $viewParams;

	}


    public function setLogin(LoginService $login) {
        $this->login = $login;
    }

    public function autenticarAction() {
    	$this->dbAdapter=$this->getServiceLocator()->get('Zend\Db\Adapter');
		
		@$usuarioactual=$this->request->getPost('username');
		@$usuariopassword=$this->request->getPost('password');
		$this->login = new LoginService($this->dbAdapter, 'comisionista', 'usr', 'psw');
        if (!$this->request->isPost()) {
            $this->redirect()->toRoute('comisionista', array('controller' => 'index'));
        }

        $form = new Login("login");
        $form->setInputFilter(new LoginValidator());

        $data = $this->request->getPost();
        $form->setData($data);

        if (!$form->isValid()) {
            $modelView = new ViewModel(array('form' => $form));
            $modelView->setTemplate('comisionista/index/index');
            $this->layout('layout/comisionistas');
            return $modelView;
        }

        $values = $form->getData();
        $us = $values['username'];
        $clave = $values['password'];

        
        try {

            $this->login->setMessage('El nombre de Usuario y Password no coinciden.',LoginService::NOT_IDENTITY);
            $this->login->setMessage('La contrasena ingresada es incorrecta. Inténtelo de nuevo.', LoginService::INVALID_CREDENTIAL);
            $this->login->setMessage('Los campos de Usuario y Password no puedendejarse en blanco.', LoginService::INVALID_LOGIN);
            $this->login->login($us, $clave);
            $this->messenger->message = "Login Correcto!!!";
            $this->messenger->value = true;
            $this->layout()->messenger = $this->messenger;
            
            $session= new Container('comisionista');
            $session->nombre=$us;
            return $this->forward()->dispatch('Comisionista\Controller\Index',array('action' => 'index'));

        } catch (\Exception $e) {

            $this->messenger->message = $e->getMessage();
            $this->messenger->value = false;
            $this->layout()->messenger = $this->messenger;
            return $this->forward()->dispatch('Comisionista\Controller\Index',array('action' => 'index'));

        }
        return $modelView;

    }

    public function logoutAction() {
    	$this->dbAdapter=$this->getServiceLocator()->get('Zend\Db\Adapter');
		$this->login = new LoginService($this->dbAdapter);
        $this->login->logout();
        session_destroy();
        $this->redirect()->toUrl('http://www.empresasveracruz.com.mx/comisionista/');

    }

    public function successAction() {

    }


	public function loginAction(){
		return new ViewModel();
	}
	public function listaAction(){
		$data=$this->request->getPost();
		$username=$data['username'];
		$password=$data['password'];
		$login=new Comisionista($username, $password);
		$datos=$login->authenticate();
		return new ViewModel(array('user'=>$datos));
	}
	
	public function pymesAction() {
		$this->dbAdapter=$this->getServiceLocator()->get('Zend\Db\Adapter');
		$lista = new Empresa($this->dbAdapter);
		
		$datos=(array(
				'titulo'	=>	'Lista (Completa) :: PYMES',
				'empresas'	=> $lista->getEmpresas()
					));
		return new ViewModel($datos);
	}
	public function detalleAction()
	{
		$this->dbAdapter=$this->getServiceLocator()->get('Zend\Db\Adapter');
		$id=(int) $this->params()->fromRoute('id',0);
		$detalle = new Empresa($this->dbAdapter);
		$valores=(array(
				'titulo'	=>	'Empresa :: ',
				'datos'	=> $detalle->getId($id),
					));
		return new ViewModel($valores);
	}
	
	public function addpymeAction(){
		$this->dbAdapter=$this->getServiceLocator()->get('Zend\Db\Adapter');
		$insertar = new Empresa($this->dbAdapter);
		$dias=365;
		$fecha=date('Y-m-d');
		
		$data = array(
				'Nombre'=>'Tiempo Development',
				'Servicios'=>'Desarrollo se SOFTWARE (CRM y ERP)',
				'idcategoria'=>101,
				'id_usuario'=>1,
				'Fecha'=>date('Y-m-d'),
				'fecha_venc'=>date("Y-m-d", strtotime("$fecha +$dias day")),
				'paquete'=>3,
				'Activa'=>'si',
			    );
		$insertar->addPyme($data);

		$datos=(array(
				'titulo'	=>	'Lista (Completa) :: PYMES',
				'empresas'	=> $insertar->getEmpresas(),
		));
		return new ViewModel($datos);
	}
	
	public function deleteAction(){
		$this->dbAdapter=$this->getServiceLocator()->get('Zend\Db\Adapter');
		$eliminar = new Empresa($this->dbAdapter);
		$id=(int) $this->params()->fromRoute('id',0);
		$eliminar->deletePyme($id);
		return $this->redirect()->toUrl($this->getRequest()->getBaseUrl().'/comisionista/home');
		
	}
	

}