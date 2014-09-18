<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Micrositio\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Sql;
use Comisionista\Form\Login;
use Zend\Db\Adapter\Adapter;
use Micrositio\Model\Entity\Usuario;;
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

class HtmlController extends AbstractActionController
{
	public $dbAdapter;
    private $login;
    private $messenger;
	private $auth;


public function __construct(){
        $this->messenger = new \stdClass();
        $this->auth = new AuthenticationService();
    }

    public function indexAction()
    { 
        $url=$this->params()->fromRoute('pagina',0);
        $this->dbAdapter=$this->getServiceLocator()->get('Zend\Db\Adapter');
        $empresas=$this->dbAdapter->query("SELECT * FROM empresa INNER JOIN categoria ON empresa.idcategoria = categoria.idcategoria WHERE empresa.url='$url' limit 1", Adapter::QUERY_MODE_EXECUTE);
        $empresas=$empresas->toArray();
        $form = new Search('search');
        $municipios = new Municipio($this->dbAdapter);
        $muni=$municipios->getMunicipios();
        $datos=array();
        foreach ($muni as $row) {
            $datos[$row->url_m] = $row->nombre_m;
        }
        if (count($empresas)==1){
        foreach ($empresas as $empresa) {
            $nombre = $empresa['Nombre']; $servicios = $empresa['Servicios']; $categoria = $empresa['nombre_categoria'];
            $ciudad2=$empresa['Ciudad'];
            $calle=$empresa['Direccion'];
            $numero=$empresa['Numero'];
            $colonia=$empresa['Colonia'];
            $cp=$empresa['Codigo_postal'];
            $telefono=$empresa['telefono'];
            $email=$empresa['email'];
            $web=$empresa['web'];
            $facebook=$empresa['face'];
            $twitter=$empresa['twitter'];
            $idcategoria=$empresa['idcategoria'];
            $logo=$empresa['nombre_foto'];
            $paquete=$empresa['paquete'];
            $suma_ratings=$empresa['suma_ratings'];
            $num_ratings=$empresa['num_rating'];
            $id=$empresa['id'];

            $direccion= $calle.', '.$numero.', '.$colonia.' '.$ciudad2.', '.'Veracruz';
            $coordenadas= @json_decode(file_get_contents(sprintf('https://maps.googleapis.com/maps/api/geocode/json?sensor=false&address=%s', urlencode($direccion))));
            @$estado=$coordenadas->status;
            if ($estado == 'OK'){
                $lat = $coordenadas->results[0]->geometry->location->lat;
                $long = $coordenadas->results[0]->geometry->location->lng;
                $coordenadas="{$lat}, {$long}";

            }
   
           
        }

        if ($paquete>1){
            $fotos=$this->dbAdapter->query("SELECT * FROM fotospyme WHERE id_pyme = $id" , Adapter::QUERY_MODE_EXECUTE);
        }
         $ciudad=$this->dbAdapter->query("SELECT * FROM municipio WHERE nombre_m = '".$ciudad2."' limit 1" , Adapter::QUERY_MODE_EXECUTE);
            foreach ($ciudad as $ciudade) {
                $ciudad=$ciudade['nombre_m'];
                $ciudad_url=$ciudade['url_m'];
                $titulo= $nombre.' | '.$categoria.' en '.$ciudad;
            }
            

        
        $videos=$this->dbAdapter->query("SELECT * FROM videos WHERE id_empresa=$id", Adapter::QUERY_MODE_EXECUTE);
        $videos=$videos->toArray();
        $comentarios = new Comentarios($this->dbAdapter);
        $usuario= new Usuario($this->dbAdapter);
        $comentarios = $comentarios->getComentarios($id);
        $comments=array();
        $i=0;
        foreach ($comentarios as $row) {
            $us = $usuario->getUser($row['id_user']);
            $comments[$i]['user']=$us;
            $comments[$i]['content']=$row['content'];
            $comments[$i]['calificacion']=$row['calificacion'];
            $i=$i+1;
        }
    	$layout = new ViewModel(array('pagina'=>$url, 'titulo'=>$titulo,
            'nombre'=>$nombre, 
            'servicios'=>$servicios, 
            'categoria'=>$categoria,
            'ciudad'=> $ciudad,
            'ciudad_url'=>$ciudad_url,
            'url'=>$url,
            'calle'=>$calle,
            'numero'=>$numero,
            'colonia'=>$colonia,
            'cp'=>$cp,
            'telefono'=>$telefono,
            'email'=>$email,
            'web'=>$web,
            'facebook'=>$facebook,
            'twitter'=>$twitter,
            'idcategoria'=>$idcategoria,
            'logo'=>$logo,
            'paquete'=>$paquete,
            'suma_ratings'=>$suma_ratings,
            'total_ratings'=>$num_ratings,
            'fotos'=>@$fotos,
            'videos'=>$videos,
            'coordenadas'=>$coordenadas,
            'comentarios'=>$comments,
            'id_empresa'=>$id,
            'municipios'=>$datos,
            'form'=>$form
            ));
    	 $this->layout('layout/premium');
    	 return $layout;
        }
        else {
        $this->layout('layout/simple');
        return $this->notFoundAction();
        }
    }

    public function clientesAction (){
        $formlogin = new Login('login');
        $this->dbAdapter=$this->getServiceLocator()->get('Zend\Db\Adapter');
        $usuario=$this->request->getPost('username');
        $password=$this->request->getPost('password');
        $this->login = new LoginService($this->dbAdapter, 'usuario', 'us', 'contrasena');
        $loggedIn = $this->login->isLoggedIn();

        $layout = new ViewModel(array(
            'form'=>$formlogin,
            'titulo'=>'Acceso : Usuarios',
            'loggedIn'=> $loggedIn,
            'mensaje'=>@$this->messenger->message,
            'usuario'=>$usuario, 'password'=>$password
            ));
        $this->layout('layout/simple');
        $user=$this->login->getIdentity();
        if($loggedIn){
            $session2 = new Container('usuario');
            $session2->usuario=$user;
            $this->redirect()->toUrl($this->getRequest()->getBaseUrl().'/clientes_home');
        }
         return $layout;
     

    }
     public function loginAction (){
        $this->dbAdapter=$this->getServiceLocator()->get('Zend\Db\Adapter');
        @$us=$this->request->getPost('username');
        @$password=$this->request->getPost('password');
        $this->login = new LoginService($this->dbAdapter, 'usuario', 'us', 'contrasena');
        if (!$this->request->isPost()) {
            $this->redirect()->toUrl($this->basePath().'/usuario/');
        }

        $form = new Login("login");
        $form->setInputFilter(new LoginValidator());
        $data = $this->request->getPost();
        $form->setData($data);
        if (!$form->isValid()) {
            $modelView = new ViewModel(array('form' => $form, 'usuario'=>$us));
            $modelView->setTemplate('micrositio/html/clientes');
            $this->layout('layout/simple');
            return $modelView;
        }

        $values = $form->getData();
        $us= $values['username'];
        $pass = $values['password'];

        try {

            $this->login->setMessage('El nombre de Usuario y Password no coinciden.',LoginService::NOT_IDENTITY);
            $this->login->setMessage('La contrasena ingresada es incorrecta. Inténtelo de nuevo.', LoginService::INVALID_CREDENTIAL);
            $this->login->setMessage('Los campos de Usuario y Password no pueden dejarse en blanco.', LoginService::INVALID_LOGIN);
            $this->login->login($us, $pass);
            $this->messenger->message = "Login Correcto!!!";
            $this->messenger->value = true;
            $this->layout()->messenger = $this->messenger;
            
            $session2= new Container('usuario');
            $session2->us=$us;
            return $this->forward()->dispatch('Micrositio\Controller\Html',array('action' => 'home', 'email'=>$email, 'password'=>$password));

        } catch (\Exception $e) {

            $this->messenger->message = $e->getMessage();
            $this->messenger->value = false;
            $this->layout()->messenger = $this->messenger;
            return $this->forward()->dispatch('Micrositio\Controller\Html',array('action' => 'clientes','email'=>$email, 'password'=>$password));

        }
        return $modelView;

    }

    public function homeAction(){

        $session2 = new Container('usuario');
        $nom_usuario = $session2->usuario->Nombre;
        if ($nom_usuario==''){
            $this->redirect()->toUrl($this->getRequest()->getBaseUrl().'/acceso_clientes');
        }
        $layout = new ViewModel(array('nombre'=>$nom_usuario));
        $this->layout('layout/cpanel');
        return $layout;
    }   
    public function fbloginAction(){
     
    $config = array(
        'appId' => '1374462339484653',
        'secret' => '35662db41178b54ec23f3c080e38470c',
      );
        $facebook = new Facebook($config);
        $user_id = $facebook->getUser();

        if($user_id) {

      // We have a user ID, so probably a logged in user.
      // If not, we'll get an exception, which we handle below.
      try {

        $user_profile = $facebook->api('/me','GET');
        $name=$user_profile['name'];
        $username=$user_profile['username'];
        $params = array( 'next' => 'http://localhost/facebook/public/examples/logout/' );
        $logout_url=$facebook->getLogoutUrl($params);

      } catch(FacebookApiException $e) {
        // If the user is logged out, you can have a 
        // user ID even though the access token is invalid.
        // In this case, we'll get an exception, so we'll
        // just ask the user to login again here.
        $login_url = $facebook->getLoginUrl(array('scope' => 'offline_access,email,user_birthday,publish_stream,read_stream,user_status'));
        error_log($e->getType());
        error_log($e->getMessage());
      }
  }
  else {
     $login_url = $facebook->getLoginUrl(array('scope' => 'offline_access,email,user_birthday,publish_stream,read_stream,user_status'));
        return $this->redirect()->toUrl($login_url);
    }

        $layout = new ViewModel(array('login' => @$login_url,
            'name'=>$name,
            'username'=>$username));
        $this->layout('layout/simple');
        return $layout;

    }
    public function logoutfaceAction(){
        $config = array(
        'appId' => '1374462339484653',
        'secret' => '35662db41178b54ec23f3c080e38470c',
      );
        $facebook = new Facebook($config);
        $facebook->destroySession();
        $layout = new ViewModel();
        $this->layout('layout/simple');
        return $layout;
    }

        public function mensajeAction(){
	$id_empresa=$this->params()->fromRoute('id',0);
	$auth = $this->auth;
        $identi=$auth->getStorage()->read();
         if($identi->Nombre==''){
            return $this->redirect()->toUrl($this->getRequest()->getBaseUrl().'/_loginmsj_'.$id_empresa);
         }
 
            else{
        $layout = new ViewModel(array(
            'nombre'=>$identi->Nombre,
            'id_user'=>$identi->id_usuario,
            'id_empresa'=>$id_empresa,
            'email_user'=>$identi->email));
        $this->layout('layout/ajax');
        return $layout;
    }
        }

        public function msjAction(){
         $this->dbAdapter=$this->getServiceLocator()->get('Zend\Db\Adapter');
         $id_empresa=$this->request->getPost('id_empresa');
         $id_user=$this->request->getPost('id_user');
         $nombre=htmlentities($this->request->getPost('nombre'));
         $email=htmlentities($this->request->getPost('email'));
         $asunto=htmlentities($this->request->getPost('asunto'));
         $mensaje=htmlentities($this->request->getPost('mensaje'));
         if($id_empresa=='' || $id_user=='' || $nombre=='' || $email=='' || $asunto=='' || $mensaje==''){
            $mensaje='<span>Imposible enviar</span> mensaje | <a href="javascript:history.back()">Regresar al Mensaje</a>';
            $status=0;
        }
        else{
            $mensaje='<span>Mensaje</span> Enviado...';
            $status=200;
        }
        $layout = new ViewModel(array('mensaje' => $mensaje,'status'=>$status));
            $this->layout('layout/ajax');
        return $layout;
        }

        public function comentarioAction(){
        $auth = $this->auth;
         $identi=$auth->getStorage()->read();
         if($identi){
            $form = new Comentario('comentario');
            $layout = new ViewModel(array('form' => $form));
            $this->layout('layout/simple');
         }

        else {
            $layout = new ViewModel();
            $this->layout('layout/simple');
        }
        return $layout;
        }

        public function loginmsjAction(){
$id_empresa=$this->params()->fromRoute('id',0);
	$auth = $this->auth;
         $identi=$auth->getStorage()->read();
         if($identi!=false && $identi!=null){
            return $this->redirect()->toUrl($this->getRequest()->getBaseUrl().'/enviar_mensaje_'.$id_empresa);
         }
 
        else {

       $this->dbAdapter=$this->getServiceLocator()->get('Zend\Db\Adapter');
        @$us=$this->request->getPost('username');
        @$password=$this->request->getPost('password');

	//Si nos llegan datos por post
        if($us!='' && $password!=''){
         
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
               $this->flashMessenger()->addMessage("Credenciales incorrectas, intentalo de nuevo");
               $this->redirect()->toRoute($this->getRequest()->getBaseUrl().'_loginmsj_'.$id_empresa);
		

           }else{
            
             // Le decimos al servicio que guarde en una sesión
             // el resultado del login cuando es correcto
             $auth->getStorage()->write($authAdapter->getResultRowObject());
              
             //Nos redirige a una pagina interior

              $this->redirect()->toUrl($this->getRequest()->getBaseUrl().'/enviar_mensaje_'.$id_empresa.'');
           }
        }     
       
  if ($identi){
            $this->redirect()->toUrl($this->getRequest()->getBaseUrl().'/enviar_mensaje_'.$id_empresa.'');
           }
        $modelView = new ViewModel(array('usuario'=>@$usuario,
            'mensaje'=>@$mensaje));
        $this->layout('layout/simple');
        return $modelView;
   }


 }
 public function opinionAction(){
        $this->dbAdapter=$this->getServiceLocator()->get('Zend\Db\Adapter');
        $id_empresa=$this->params()->fromRoute('id',0);
        $session2 = new Container('usuario');
        $nom_usuario = $session2->usuario->Nombre;
        if ($nom_usuario==''){
            $this->redirect()->toUrl($this->getRequest()->getBaseUrl().'/_loginmsj_'.$id_empresa.'');
        }
            else{
        $layout = new ViewModel(array(
            'nombre'=>$nom_usuario,
            'id_user'=>$session2->usuario->id_usuario,
            'id_empresa'=>$id_empresa,
            'email_user'=>$session2->usuario->email));
        $this->layout('layout/simple');
        return $layout;
    }
        }


public function cuponesAction(){
    $this->dbAdapter=$this->getServiceLocator()->get('Zend\Db\Adapter');
    $municipios = new Municipio($this->dbAdapter);
        $muni=$municipios->getMunicipios();
        $datos=array();
        foreach ($muni as $row) {
            $datos[$row->url_m] = $row->nombre_m;
        }
    $form = new Search('search');
    $formRegistro= new User('registro');
     $layout = new ViewModel(array(
        'form'=>$form, 
        'formRegistro'=>$formRegistro,
        'municipios'=>$datos));
    $this->layout('layout/cupones');
    return $layout;
}
public function pymesAction(){
    $this->dbAdapter=$this->getServiceLocator()->get('Zend\Db\Adapter');
    $municipios = new Municipio($this->dbAdapter);
        $muni=$municipios->getMunicipios();
        $datos=array();
        foreach ($muni as $row) {
            $datos[$row->url_m] = $row->nombre_m;
        }
    $form = new Search('search');
    $formRegistro= new User('registro');
     $layout = new ViewModel(array(
        'form'=>$form, 
        'formRegistro'=>$formRegistro,
        'municipios'=>$datos));
    $this->layout('layout/pymes');
    return $layout;
}

    
}
