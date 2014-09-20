<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Usuario\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Sql;
use Comisionista\Form\Login;
use Zend\Db\Adapter\Adapter;
use Micrositio\Form\LoginValidator;
use Micrositio\Model\Entity\Usuario;
use Facebook\Controller\Facebook;
use Zend\Mail;
use Micrositio\Model\Entity\Comentarios;
use Micrositio\Form\Comentario;
use Principal\Model\Entity\Empresa;
use Principal\Model\Entity\Municipio;
use Principal\Model\Entity\Cupon;
use Principal\Form\Search;
use Micrositio\Form\User;
use Zend\Authentication\Adapter\DbTable as AuthAdapter;
 
//Componentes de autenticación
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session as SessionStorage;
use Zend\Session\Container;


class IndexController extends AbstractActionController
{
	public function __construct(){
        $this->messenger = new \stdClass();
        $this->auth = new AuthenticationService();
    }

    private $dbAdapter;
    private $auth;
    private $login;
    private $messenger;

public function indexAction(){
        $formlogin = new Login('login');
        $mensaje = '';
        $auth = $this->auth;
         $identi=$auth->getStorage()->read();
         if($identi!=false && $identi!=null){
            return $this->redirect()->toUrl($this->getRequest()->getBaseUrl().'/usuario/cpanel');
         }
          $this->dbAdapter=$this->getServiceLocator()->get('Zend\Db\Adapter');

        @$us=$this->request->getPost('username');
        @$password=$this->request->getPost('password');

        //Si nos llegan datos por post
        if($this->getRequest()->isPost()){
         
            /* Creamos la autenticación a la que le pasamos:
                1. La conexión a la base de datos
                2. La tabla de la base de datos
                3. El campo de la bd que hará de username
                4. El campo de la bd que hará de contraseña
            */
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
            $authAdapter->setIdentity($this->getRequest()->getPost("username"))
                        ->setCredential($this->getRequest()->getPost("password"));
             
            
           //Le decimos al servicio de autenticación que el adaptador
           $auth->setAdapter($authAdapter);
            
           //Le decimos al servicio de autenticación que lleve a cabo la identificacion
           $result=$auth->authenticate();
          
           //Si el resultado del login es falso, es decir no son correctas las credenciales
           if($authAdapter->getResultRowObject()==false){
            
               //Crea un mensaje flash y redirige
               $mensaje="Credenciales incorrectas, intentalo de nuevo.";
               $this->redirect()->toUrl($this->getRequest()->getBaseUrl().'/usuario/');
           }else{
            
             // Le decimos al servicio que guarde en una sesión
             // el resultado del login cuando es correcto
             $auth->getStorage()->write($authAdapter->getResultRowObject());
              
             //Nos redirige a una pagina interior

              return $this->redirect()->toUrl($this->getRequest()->getBaseUrl().'/usuario/cpanel');
           }
        }
        $layout = new ViewModel(array(
            'form'=>$formlogin,
            'titulo'=>'Acceso : Usuarios',
            'mensaje'=>$mensaje,
            'usuario'=>$us, 'password'=>$password
            ));

        $this->layout('layout/layout');
        return $layout;
     

    }
     public function loginfbAction (){
        $auth = $this->auth;
         $identi=$auth->getStorage()->read();
         if($identi!=false ){
            return $this->redirect()->toUrl($this->getRequest()->getBaseUrl().'/usuario/cpanel');
         }
         $config = array(
        'appId' => '511970112239573',
        'secret' => '078fcc2f16ef634a28b5f48f594f9d65',
      );
        $facebook = new Facebook($config);
        $user_id = $facebook->getUser();

        if($user_id) {

      // We have a user ID, so probably a logged in user.
      // If not, we'll get an exception, which we handle below.
      try {

        $user_profile = $facebook->api('/me','GET');
        $amigos = $facebook->api('/me/friends', 'GET');
        $name=$user_profile['name'];
        $email=$user_profile['email'];
        $permiso_pub = $facebook->api('/me/permissions', 'GET');
        $logout_url="http://empresasveracruz.com/usuario/index/logout";

      } catch(FacebookApiException $e) {
        // If the user is logged out, you can have a 
        // user ID even though the access token is invalid.
        // In this case, we'll get an exception, so we'll
        // just ask the user to login again here.
        $login_url = $facebook->getLoginUrl(array('scope' => 'offline_access,email,user_friends,publish_actions'));
        error_log($e->getType());
        error_log($e->getMessage());
      }
  }
  else {
     $login_url = $facebook->getLoginUrl(array('scope' => 'offline_access,email,user_friends,publish_actions'));
        return $this->redirect()->toUrl($login_url);
    }

        $layout = new ViewModel(array('login' => @$login_url,
            'name'=>$name,
            'email'=>$email,
            'user'=>$permiso_pub,
            'logout'=>$logout_url));
        $this->layout('layout/layout');
        return $layout;

    }

    function logoutAction(){
      $config = array(
        'appId' => '511970112239573',
        'secret' => '078fcc2f16ef634a28b5f48f594f9d65',
      );
        $facebook = new Facebook($config);
        $facebook->destroySession();
        $this->auth->clearIdentity();
        return $this->redirect()->toUrl($this->getRequest()->getBaseUrl().'/usuario/');
    }
          


}
?>