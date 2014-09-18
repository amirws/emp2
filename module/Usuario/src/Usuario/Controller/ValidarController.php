<?php

namespace Usuario\Controller;

use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session as SessionStorage;
use Zend\Session\Container;
use Micrositio\Model\Entity\Usuario;
use Zend\Authentication\Adapter\DbTable as AuthAdapter;

class ValidarController extends AbstractActionController {
	
	public function __construct(){
		$this->messenger = new \stdClass();
		$this->auth = new AuthenticationService();
	}
	
	public $dbAdapter;
	private $login;
	private $messenger;
	
	public function indexAction(){
		$this->dbAdapter=$this->getServiceLocator()->get('Zend\Db\Adapter');
		$auth = $this->auth;
		$id= $this->params()->fromRoute('id',0);
		$cod=$this->params()->fromRoute('validar',0);

		if ($this->getRequest()->isPost()){
			$usuario=$this->getRequest()->getPost();
			$id=$usuario['id'];
			$codigo=$usuario['codigo']; 
			$busqueda = new Usuario($this->dbAdapter);
			$usuario1= $busqueda->SearchValidarUsuario($id, $codigo);
			if (count($usuario1)==1){
				$usuarioupdate=array(
					'us'=>$usuario['username'],
					'Nombre'=>$usuario['nombre'],
					'direccion'=>$usuario['direccion'],
					'verificado'=>'si',
					);
				$busqueda->actualizar($usuarioupdate, $id);
				$authAdapter = new AuthAdapter($this->dbAdapter,
                                           'usuario',
                                           'us',
                                           'contrasena'
                                           );
                                            
           /* 
            Podemos hacer lo mismo de esta manera:
            $authAdapter = new AuthAdapter($dbAdapter);
            $authAdapter
                ->setTableName('users')
                ->setIdentityColumn('username')
                ->setCredentialColumn('password');
           */
 
           /*
           En el caso de que la contraseña en la db este cifrada
           tenemos que utilizar el mismo algoritmo de cifrado
           */
            
             
            //Establecemos como datos a autenticar los que nos llegan del formulario
            $authAdapter->setIdentity($usuario['username'])
                        ->setCredential($usuario1[0]['contrasena']);
             
            
           //Le decimos al servicio de autenticación que el adaptador
           $auth->setAdapter($authAdapter);
            
           //Le decimos al servicio de autenticación que lleve a cabo la identificacion
           $result=$auth->authenticate();
          
           //Si el resultado del login es falso, es decir no son correctas las credenciales
           if($authAdapter->getResultRowObject()==false){
            
               //Crea un mensaje flash y redirige
               $mensaje ="Credenciales Incorrectas. ";
           }
           else{
            
             // Le decimos al servicio que guarde en una sesión
             // el resultado del login cuando es correcto
             $auth->getStorage()->write($authAdapter->getResultRowObject());
              
             //Nos redirige a una pagina interior

              return $this->redirect()->toUrl($this->getRequest()->getBaseUrl().'/usuario/cpanel');
           }
		}
	}
		else {

		$busqueda = new Usuario($this->dbAdapter);
		$usuario = $busqueda->SearchValidarUsuario($id, $cod);
		$username = @$usuario[0]['us'];
		$verificado = @$usuario[0]['verificado'];
		$email = @$usuario[0]['email'];

	}
		$vista = new ViewModel(array(
			'id'=>@$usuario[0]['id_usuario'],
			'codigo'=>@$usuario[0]['cod'],
			'verificado'=>@$verificado,
			'email'=>@$email,
			'mensaje'=>@$mensaje,
			'username'=>@$username));

			$this->layout('layout/layout');
		return  $vista;
	}
	
	
}