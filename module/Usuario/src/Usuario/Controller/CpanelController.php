<?php
namespace Usuario\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Sql;
use Comisionista\Form\Login;
use Zend\Db\Adapter\Adapter;
use Micrositio\Form\LoginValidator;
use Micrositio\Model\Entity\LoginUser as LoginService;
use Micrositio\Model\Entity\Usuario;
use Facebook\Controller\Facebook;
use Zend\Mail;
use Micrositio\Model\Entity\Comentarios;
use Micrositio\Form\Comentario;
use Principal\Model\Entity\Empresa;
use Principal\Model\Entity\Categoria;
use Principal\Model\Entity\Cupon;
use Principal\Model\Entity\Banner;
use Principal\Form\Search;
use Micrositio\Form\User;
use Zend\Authentication\Adapter\DbTable as AuthAdapter;
use Usuario\Model\Orders;
//Componentes de autenticación
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session as SessionStorage;
use Zend\Session\Container;
use Usuario\Model\Municipio;
use Principal\Model\Entity\Bitacora;

class CpanelController extends AbstractActionController
{
	public function __construct(){
        $this->messenger = new \stdClass();
         $this->auth = new AuthenticationService();
    }

	public $dbAdapter;
    private $login;
    private $messenger;

public function indexAction(){
   		$this->dbAdapter=$this->getServiceLocator()->get('Zend\Db\Adapter');
         $identi=$this->auth->getStorage()->read();
         if($identi!=false && $identi!=null){
            $datos=$identi;
         }else{
             $this->redirect()->toUrl($this->getRequest()->getBaseUrl().'/usuario/');
         }
        $nom_usuario=$datos->Nombre;
        $id_user=$datos->id_usuario;
        $SearchPymes=new Empresa($this->dbAdapter);
        $Pymes=$SearchPymes->SearchUser($id_user);
        $promociones=$this->dbAdapter->query("SELECT * FROM cuponera  WHERE id_user = '$id_user' order by id_cupon Desc", Adapter::QUERY_MODE_EXECUTE);

        $layout = new ViewModel(array(
        	'nombre'=>$nom_usuario,
        	'id_user'=>$id_user,
        	'NumPymes'=>count($Pymes),
            'pymes'=>$Pymes
        	));
        $this->layout('layout/cpanel');
        return $layout;
    
    }


    public function editarAction(){
        $this->dbAdapter=$this->getServiceLocator()->get('Zend\Db\Adapter');
        $id_pyme=$this->getRequest()->getPost('id');
        $identi=$this->auth->getStorage()->read();
         if($identi!=false && $identi!=null){
            $datos=$identi;
         }else{
             $this->redirect()->toUrl($this->getRequest()->getBaseUrl().'/usuario/');
         }
        $id_user=$datos->id_usuario;
        $pyme = new Empresa ($this->dbAdapter);
        $pyme = $pyme->getIdPyme($id_pyme);
        foreach ($pyme as $py){
        	$paquete=$py['paquete'];
        	
        }
        if ($paquete==0){
        	$this->redirect()->toUrl($this->getRequest()->getBaseUrl().'/usuario/cpanel/editarfree/'.$id_pyme);
        }
        elseif($paquete==1){
        	$this->redirect()->toUrl($this->getRequest()->getBaseUrl().'/usuario/cpanel/editarbasico/'.$id_pyme);
        }
        elseif($paquete==2){
        	$this->redirect()->toUrl($this->getRequest()->getBaseUrl().'/usuario/cpanel/editarestandar/'.$id_pyme);
        }
        elseif($paquete==3){
        	$this->redirect()->toUrl($this->getRequest()->getBaseUrl().'/usuario/cpanel/editarpremium/'.$id_pyme);
        }
         $layout= new ViewModel();
        $this->layout('layout/ajax');
        return $layout;
    }
    public function editarbasicoAction(){
    	$this->dbAdapter=$this->getServiceLocator()->get('Zend\Db\Adapter');
    	$id_pyme=$this->getEvent()->getRouteMatch()->getParam('id', null);
    	$identi=$this->auth->getStorage()->read();
    	if($identi!=false){
    		$datos=$identi;
    	}else{
    		$this->redirect()->toUrl($this->getRequest()->getBaseUrl().'/usuario/');
    	}
    	$id_user=$datos->id_usuario;
    	$pyme = new Empresa ($this->dbAdapter);
    	$pyme = $pyme->getIdPyme($id_pyme);
    	$municipios=new Municipio($this->dbAdapter);
    	$muni=$municipios->getMunicipios();
    	foreach ($pyme as $py) {
    		$nombre=$py['Nombre'];
    		$servicios=$py['Servicios'];
    		$micrositio=$py['url'];
    		$calle=$py['Direccion'];
    		$numero=$py['Numero'];
    		$colonia=$py['Colonia'];
    		$ciudad=$py['Ciudad'];
    		$cp=$py['Codigo_postal'];
    		$telefono=$py['telefono'];
    		$email=$py['email'];
    		$web=$py['web'];
    		$face=$py['face'];
    		$twitter=$py['twitter'];
    		$logo=$py['nombre_foto'];
    		$idcategoria=$py['idcategoria'];
    		}

    		$categoria=$pyme[0]['nombre_categoria'];
    	
    	if ($this->getRequest()->isPost()){
    		$nombre=$this->getRequest()->getPost('nombre');
    		$servicios=htmlspecialchars($this->getRequest()->getPost('servicios'));
    		$calle=htmlspecialchars($this->getRequest()->getPost('calle'));
    		$numero=htmlspecialchars($this->getRequest()->getPost('numero'));
    		$colonia=htmlspecialchars($this->getRequest()->getPost('colonia'));
    		$ciudad=$this->getRequest()->getPost('ciudad');
    		$cp=htmlspecialchars($this->getRequest()->getPost('cp'));
    		$email=htmlspecialchars($this->getRequest()->getPost('email'));
    		$telefono=htmlspecialchars($this->getRequest()->getPost('telefono'));
    		$web=htmlspecialchars($this->getRequest()->getPost('web'));
    		
    		if ($nombre!='' && $servicios!='' && $calle!='' && $numero!='' && $colonia!='' && $ciudad!='' && $cp!='' && $email!='' && $telefono!='' && $web!=''){
    			if (!@ereg("^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]",$email)) {
    				$mensaje='danger';
    				$mensaje2='<strong>Error:</strong> * E-mail Incorrecto.';
    			}
    			else{
    			$data=array(
    					'Nombre'=>$nombre,
    					'Servicios'=>$servicios,
    					'Direccion'=>$calle,
    					'Numero'=>$numero,
    					'Colonia'=>$colonia,
    					'Ciudad'=>$ciudad,
    					'Codigo_postal'=>$cp,
    					'telefono'=>$telefono,
    					'email'=>$email,
    					'web'=>$web
    					);
    			$insertar= new Empresa($this->dbAdapter);
    			$insertar->updatePyme($id_pyme, $data);
    			$mensaje='success';
    			$mensaje2='<strong>Felicidades!</strong> * Guardado Correctamente.';
    			$insertar= new Empresa($this->dbAdapter);
    			$insertar->updatePyme($id_pyme, $data);
    			$bitacora = new Bitacora($this->dbAdapter);
                date_default_timezone_set('America/Mexico_City');
    			$bitacoraarray=array('id'=>'',
    					'descripcion'=>'update empresa',
    					'user'=>$datos->id_usuario,
    					'fecha'=>date('Y-m-d H:i:s'),
    					'id_pyme'=>$pyme[0]['id'],
    			);
    			$bitacora->insertar($bitacoraarray);
    			}
    		}

    		else {
    			$mensaje='warning';
    			$mensaje2='<strong>Error:</strong> * Campo Incompleto';
    		}
    		
    	}
    	else {
    		$mensaje='info';
    		$mensaje2='<strong>Aviso: </strong>Llenar campos correctamente. No dejar campos vacios.';
    	}
    	$layout = new ViewModel(array(
    			'id_user'=>$id_user,
    			'id_pyme'=>$id_pyme,
    			'municipios'=>$muni,
    			'nombre'=>$nombre,
    			'micrositio'=>$micrositio,
    			'calle'=>$calle,
    			'servicios'=>$servicios,
    			'numero'=>$numero,
    			'colonia'=>$colonia,
    			'ciudad'=>$ciudad,
    			'cp'=>$cp,
    			'telefono'=>$telefono,
    			'email'=>$email,
    			'web'=>$web,
    			'face'=>$face,
    			'twitter'=>$twitter,
    			'mensaje'=>$mensaje,
    			'mensaje2'=>$mensaje2,
    			'logo'=>$logo,
    			'categoria'=>$categoria
    			    	));
    	$this->layout('layout/ajax');
    	return $layout;
    }
    public function editarestandarAction(){
    	$this->dbAdapter=$this->getServiceLocator()->get('Zend\Db\Adapter');
    	$id_pyme=$this->getEvent()->getRouteMatch()->getParam('id', null);
    	$identi=$this->auth->getStorage()->read();
    	if($identi!=false && $identi!=null){
    		$datos=$identi;
    	}else{
    		$this->redirect()->toUrl($this->getRequest()->getBaseUrl().'/usuario/');
    	}
    	$id_user=$datos->id_usuario;
    	$pyme = new Empresa ($this->dbAdapter);
    	$pyme = $pyme->getIdPyme($id_pyme);
    	$municipios=new Municipio($this->dbAdapter);
    	$muni=$municipios->getMunicipios();
    	foreach ($pyme as $py) {
    		$nombre=$py['Nombre'];
    		$servicios=$py['Servicios'];
    		$micrositio=$py['url'];
    		$calle=$py['Direccion'];
    		$numero=$py['Numero'];
    		$colonia=$py['Colonia'];
    		$ciudad=$py['Ciudad'];
    		$cp=$py['Codigo_postal'];
    		$telefono=$py['telefono'];
    		$email=$py['email'];
    		$web=$py['web'];
    		$face=$py['face'];
    		$twitter=$py['twitter'];
    		$logo=$py['nombre_foto'];
    		$facebook=$py['face'];
    		$twitter=$py['twitter'];
    		$idcategoria=$py['idcategoria'];
    		}
    		$categoria=$pyme[0]['nombre_categoria'];
    	
    	if ($this->getRequest()->isPost()){
    		$nombre=$this->getRequest()->getPost('nombre');
    		$servicios=htmlspecialchars($this->getRequest()->getPost('servicios'));
    		$calle=htmlspecialchars($this->getRequest()->getPost('calle'));
    		$numero=htmlspecialchars($this->getRequest()->getPost('numero'));
    		$colonia=htmlspecialchars($this->getRequest()->getPost('colonia'));
    		$ciudad=$this->getRequest()->getPost('ciudad');
    		$cp=htmlspecialchars($this->getRequest()->getPost('cp'));
    		$email=htmlspecialchars($this->getRequest()->getPost('email'));
    		$telefono=htmlspecialchars($this->getRequest()->getPost('telefono'));
    		$web=htmlspecialchars($this->getRequest()->getPost('web'));
    		$facebook=$this->getRequest()->getPost('facebook');
    		$twitter=$this->getRequest()->getPost('twitter');
    		
    		if ($nombre!='' && $servicios!='' && $calle!='' && $numero!='' && $colonia!='' && $ciudad!='' && $cp!='' && $email!='' && $telefono!=''){
    			if (!@ereg("^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]",$email)) {
    				$mensaje='danger';
    				$mensaje2='<strong>Error:</strong> * E-mail Incorrecto.';
    			}
    			else{
    			$data=array(
    					'Nombre'=>$nombre,
    					'Servicios'=>$servicios,
    					'Direccion'=>$calle,
    					'Numero'=>$numero,
    					'Colonia'=>$colonia,
    					'Ciudad'=>$ciudad,
    					'Codigo_postal'=>$cp,
    					'telefono'=>$telefono,
    					'email'=>$email,
    					'web'=>$web,
    					'face'=>$facebook,
    					'twitter'=>$twitter
    					);
    			$insertar= new Empresa($this->dbAdapter);
    			$insertar->updatePyme($id_pyme, $data);
    			$mensaje='success';
    			$mensaje2='<strong>Felicidades!</strong> * Guardado Correctamente.';
    			$insertar= new Empresa($this->dbAdapter);
    			$insertar->updatePyme($id_pyme, $data);
    			$bitacora = new Bitacora($this->dbAdapter);
                date_default_timezone_set('America/Mexico_City');
    			$bitacoraarray=array('id'=>'',
                        'descripcion'=>'update empresa',
                        'user'=>$datos->id_usuario,
                        'fecha'=>date('Y-m-d H:i:s'),
                        'id_pyme'=>$pyme[0]['id'],
                );
                $bitacora->insertar($bitacoraarray);
                }
    		}

    		else {
    			$mensaje='warning';
    			$mensaje2='<strong>Error:</strong> * Campo Incompleto';
    		}
    		
    	}
    	else {
    		$mensaje='info';
    		$mensaje2='<strong>Aviso: </strong>Llenar campos correctamente. No dejar campos vacios.';
    	}
    	$layout = new ViewModel(array(
    			'id_user'=>$id_user,
    			'id_pyme'=>$id_pyme,
    			'municipios'=>$muni,
    			'nombre'=>$nombre,
    			'micrositio'=>$micrositio,
    			'calle'=>$calle,
    			'servicios'=>$servicios,
    			'numero'=>$numero,
    			'colonia'=>$colonia,
    			'ciudad'=>$ciudad,
    			'cp'=>$cp,
    			'telefono'=>$telefono,
    			'email'=>$email,
    			'web'=>$web,
    			'face'=>$face,
    			'twitter'=>$twitter,
    			'mensaje'=>$mensaje,
    			'mensaje2'=>$mensaje2,
    			'logo'=>$logo,
    			'facebook'=>$facebook,
    			'twitter'=>$twitter,
    			'categoria'=>$categoria
    			    	));
    	$this->layout('layout/ajax');
    	return $layout;
    }
    public function editarpremiumAction(){
    	$this->dbAdapter=$this->getServiceLocator()->get('Zend\Db\Adapter');
    	$id_pyme=$this->getEvent()->getRouteMatch()->getParam('id', null);
    	$identi=$this->auth->getStorage()->read();
    	if($identi!=false && $identi!=null){
    		$datos=$identi;
    	}else{
    		$this->redirect()->toUrl($this->getRequest()->getBaseUrl().'/usuario/');
    	}
    	$id_user=$datos->id_usuario;
    	$pyme = new Empresa ($this->dbAdapter);
    	$pyme = $pyme->getIdPyme($id_pyme);
    	$municipios=new Municipio($this->dbAdapter);
    	$muni=$municipios->getMunicipios();
    	foreach ($pyme as $py) {
    		$nombre=$py['Nombre'];
    		$servicios=$py['Servicios'];
    		$micrositio=$py['url'];
    		$calle=$py['Direccion'];
    		$numero=$py['Numero'];
    		$colonia=$py['Colonia'];
    		$ciudad=$py['Ciudad'];
    		$cp=$py['Codigo_postal'];
    		$telefono=$py['telefono'];
    		$email=$py['email'];
    		$web=$py['web'];
    		$face=$py['face'];
    		$twitter=$py['twitter'];
    		$logo=$py['nombre_foto'];
    		$facebook=$py['face'];
    		$twitter=$py['twitter'];
    		$idcategoria=$py['idcategoria'];
    		}
    		$categoria= $pyme[0]['nombre_categoria'];
    	
    	if ($this->getRequest()->isPost()){
    		$nombre=$this->getRequest()->getPost('nombre');
    		$servicios=htmlspecialchars($this->getRequest()->getPost('servicios'));
    		$calle=htmlspecialchars($this->getRequest()->getPost('calle'));
    		$numero=htmlspecialchars($this->getRequest()->getPost('numero'));
    		$colonia=htmlspecialchars($this->getRequest()->getPost('colonia'));
    		$ciudad=$this->getRequest()->getPost('ciudad');
    		$cp=htmlspecialchars($this->getRequest()->getPost('cp'));
    		$email=htmlspecialchars($this->getRequest()->getPost('email'));
    		$telefono=htmlspecialchars($this->getRequest()->getPost('telefono'));
    		$web=htmlspecialchars($this->getRequest()->getPost('web'));
    		$facebook=$this->getRequest()->getPost('facebook');
    		$twitter=$this->getRequest()->getPost('twitter');
    		
    		if ($nombre!='' && $servicios!='' && $calle!='' && $numero!='' && $colonia!='' && $ciudad!='' && $cp!='' && $email!='' && $telefono!=''){
    			if (!@ereg("^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]",$email)) {
    				$mensaje='danger';
    				$mensaje2='<strong>Error:</strong> * E-mail Incorrecto.';
    			}
    			else{
    			$data=array(
    					'Nombre'=>$nombre,
    					'Servicios'=>$servicios,
    					'Direccion'=>$calle,
    					'Numero'=>$numero,
    					'Colonia'=>$colonia,
    					'Ciudad'=>$ciudad,
    					'Codigo_postal'=>$cp,
    					'telefono'=>$telefono,
    					'email'=>$email,
    					'web'=>$web,
    					'face'=>$facebook,
    					'twitter'=>$twitter
    					);
    			$insertar= new Empresa($this->dbAdapter);
    			$insertar->updatePyme($id_pyme, $data);
    			$mensaje='success';
    			$mensaje2='<strong>Felicidades!</strong> * Guardado Correctamente.';
    			$insertar= new Empresa($this->dbAdapter);
    			$insertar->updatePyme($id_pyme, $data);
    			$bitacora = new Bitacora($this->dbAdapter);
                date_default_timezone_set('America/Mexico_City');
    			$bitacoraarray=array('id'=>'',
                        'descripcion'=>'update empresa',
                        'user'=>$datos->id_usuario,
                        'fecha'=>date('Y-m-d H:i:s'),
                        'id_pyme'=>$pyme[0]['id'],
                );
                $bitacora->insertar($bitacoraarray);
                }
    		}

    		else {
    			$mensaje='warning';
    			$mensaje2='<strong>Error:</strong> * Campo Incompleto';
    		}
    		
    	}
    	else {
    		$mensaje='info';
    		$mensaje2='<strong>Aviso: </strong>Llenar campos correctamente. No dejar campos vacios.';
    	}
    	$layout = new ViewModel(array(
    			'id_user'=>$id_user,
    			'id_pyme'=>$id_pyme,
    			'municipios'=>$muni,
    			'nombre'=>$nombre,
    			'micrositio'=>$micrositio,
    			'calle'=>$calle,
    			'servicios'=>$servicios,
    			'numero'=>$numero,
    			'colonia'=>$colonia,
    			'ciudad'=>$ciudad,
    			'cp'=>$cp,
    			'telefono'=>$telefono,
    			'email'=>$email,
    			'web'=>$web,
    			'face'=>$face,
    			'twitter'=>$twitter,
    			'mensaje'=>$mensaje,
    			'mensaje2'=>$mensaje2,
    			'logo'=>$logo,
    			'facebook'=>$facebook,
    			'twitter'=>$twitter,
    			'categoria'=>$categoria
    			    	));
    	$this->layout('layout/ajax');
    	return $layout;
    }
    public function editarfreeAction(){
    	$this->dbAdapter=$this->getServiceLocator()->get('Zend\Db\Adapter');
    	$id_pyme=$this->getEvent()->getRouteMatch()->getParam('id', null);
    	$identi=$this->auth->getStorage()->read();
    	if($identi!=false && $identi!=null){
    		$datos=$identi;
    	}else{
    		$this->redirect()->toUrl($this->getRequest()->getBaseUrl().'/usuario/');
    	}
    	$id_user=$datos->id_usuario;
    	$pyme = new Empresa ($this->dbAdapter);
    	$pyme = $pyme->getIdPyme($id_pyme);
    	$municipios=new Municipio($this->dbAdapter);
    	$muni=$municipios->getMunicipios();
    	foreach ($pyme as $py) {
    		$nombre=$py['Nombre'];
    		$micrositio=$py['url'];
    		$calle=$py['Direccion'];
    		$numero=$py['Numero'];
    		$colonia=$py['Colonia'];
    		$ciudad=$py['Ciudad'];
    		$cp=$py['Codigo_postal'];
    		$telefono=$py['telefono'];
    		$email=$py['email'];
    		$web=$py['web'];
    		$face=$py['face'];
    		$twitter=$py['twitter'];
    		$idcategoria=$py['idcategoria'];
    	}
    	$categoria= $pyme[0]['nombre_categoria'];
    	if ($this->getRequest()->isPost()){
    		$nombre=htmlspecialchars($this->getRequest()->getPost('nombre'));
    		$calle=htmlspecialchars($this->getRequest()->getPost('calle'));
    		$numero=htmlspecialchars($this->getRequest()->getPost('numero'));
    		$colonia=htmlspecialchars($this->getRequest()->getPost('colonia'));
    		$ciudad=$this->getRequest()->getPost('ciudad');
    		$cp=htmlspecialchars($this->getRequest()->getPost('cp'));
    		$email=htmlspecialchars($this->getRequest()->getPost('email'));
    		$telefono=htmlspecialchars($this->getRequest()->getPost('telefono'));
    		if ($nombre!='' && $calle!='' && $numero!='' && $colonia!='' && $ciudad!='' && $cp!='' && $email!='' && $telefono!=''){
    			if (!@ereg("^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]",$email)) {
    				$mensaje='danger';
    				$mensaje2='<strong>Error:</strong> * E-mail Incorrecto.';
    			}
    			else{
    			$data=array(
    					'Nombre'=>$nombre,
    					'Direccion'=>$calle,
    					'Numero'=>$numero,
    					'Colonia'=>$colonia,
    					'Ciudad'=>$ciudad,
    					'Codigo_postal'=>$cp,
    					'telefono'=>$telefono,
    					'email'=>$email,
    					);
    			$insertar= new Empresa($this->dbAdapter);
    			$insertar->updatePyme($id_pyme, $data);
    			$bitacora = new Bitacora($this->dbAdapter);
    			date_default_timezone_set('America/Mexico_City');
                $bitacora = new Bitacora($this->dbAdapter);
                $bitacoraarray=array('id'=>'',
                        'descripcion'=>'update empresa',
                        'user'=>$datos->id_usuario,
                        'fecha'=>date('Y-m-d H:i:s'),
                        'id_pyme'=>$pyme[0]['id'],
                );
                $bitacora->insertar($bitacoraarray);
    			$mensaje='success';
    			$mensaje2='<strong>Felicidades!</strong> * Guardado Correctamente.';
    			}
    		}

    		else {
    			$mensaje='warning';
    			$mensaje2='<strong>Error:</strong> * Campo Incompleto';
    		}
    		
    	}
    	else {
    		$mensaje='info';
    		$mensaje2='<strong>Aviso: </strong>Llenar campos correctamente. No dejar campos vacios.';
    	}
    	$layout = new ViewModel(array(
    			'id_user'=>$id_user,
    			'id_pyme'=>$id_pyme,
    			'municipios'=>$muni,
    			'nombre'=>$nombre,
    			'micrositio'=>$micrositio,
    			'calle'=>$calle,
    			'numero'=>$numero,
    			'colonia'=>$colonia,
    			'ciudad'=>$ciudad,
    			'cp'=>$cp,
    			'telefono'=>$telefono,
    			'email'=>$email,
    			'web'=>$web,
    			'face'=>$face,
    			'twitter'=>$twitter,
    			'categoria'=>$categoria,
    			'mensaje'=>$mensaje,
    			'mensaje2'=>$mensaje2
    			    	));
    	$this->layout('layout/ajax');
    	return $layout;
    }
 	
	public function logoupdateAction(){
		
		$identi=$this->auth->getStorage()->read();
		$this->dbAdapter=$this->getServiceLocator()->get('Zend\Db\Adapter');
		if($identi!=false && $identi!=null){
		}
		else{
		$this->redirect()->toUrl($this->getRequest()->getBaseUrl().'/usuario/');
		}
		$busqueda=new Empresa($this->dbAdapter);
		$id_pyme=$this->getEvent()->getRouteMatch()->getParam('id', null);
		$busqueda=$busqueda->PymeUser($identi->id_usuario, $id_pyme);
		foreach($busqueda as $pyme){
			$nombre=$pyme['Nombre'];
			$logo=$pyme['nombre_foto'];
			$paquete=$pyme['paquete'];
			$id_categoria=$pyme['idcategoria'];
		}
		$banner260=new Banner($this->dbAdapter);
		$banner260=$banner260->getBaner260Pyme($id_pyme);
		
		$layout = new ViewModel(array(
			'usuario'=>$identi->Nombre,
				'nombre'=>@$nombre,
				'logo'=>@$logo,
				'id_pyme'=>@$id_pyme,
				'paquete'=>@$paquete,
				'banner260'=>$banner260,
				'id_categoria'=>$id_categoria
		));
		$this->layout('layout/logoupdate');
		return $layout;
	}
	public function uploadlogoAction(){
		/*
		 Uploadify
		Copyright (c) 2012 Reactive Apps, Ronnie Garcia
		Released under the MIT License <http://www.opensource.org/licenses/mit-license.php>
		*/
		$identi=$this->auth->getStorage()->read();
		if($identi!=false && $identi!=null){
			$datos=$identi;
		}
		else{
			$this->redirect()->toUrl($this->getRequest()->getBaseUrl().'/usuario/');
		}
		
		$this->dbAdapter=$this->getServiceLocator()->get('Zend\Db\Adapter');
		
		// Define a destination
		$targetFolder = '/uploads'; // Relative to the root
		$verifyToken = md5('unique_salt' . $_POST['timestamp']);
		
		if (!empty($_FILES) && $_POST['token'] == $verifyToken) {
			$tempFile = $_FILES['Filedata']['tmp_name'];
			$targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;
			$targetFile = rtrim($targetPath,'/') . '/' . $_FILES['Filedata']['name'];
		
			// Validate the file type
			$fileTypes = array('jpg','jpeg','gif','png'); // File extensions
			$fileParts = pathinfo($_FILES['Filedata']['name']);
		
			if (in_array($fileParts['extension'],$fileTypes)) {
				$tmpfoto=$_FILES['Filedata']['tmp_name'];
				move_uploaded_file($tempFile,$targetFile);
				$ruta_imagen=$targetFile;
				$miniatura_ancho_maximo = 165;
				$miniatura_alto_maximo = 115;
				$info_imagen = getimagesize($ruta_imagen);
				$imagen_ancho = $info_imagen[0];
				$imagen_alto = $info_imagen[1];
				$imagen_tipo = $info_imagen['mime'];
				
				$proporcion_imagen = $imagen_ancho / $imagen_alto;
				$proporcion_miniatura = $miniatura_ancho_maximo / $miniatura_alto_maximo;
				
				if ( $proporcion_imagen > $proporcion_miniatura ){
					$miniatura_ancho = $miniatura_alto_maximo * $proporcion_imagen;
					$miniatura_alto = $miniatura_alto_maximo;
				} else if ( $proporcion_imagen < $proporcion_miniatura ){
					$miniatura_ancho = $miniatura_ancho_maximo;
					$miniatura_alto = $miniatura_ancho_maximo / $proporcion_imagen;
				} else {
					$miniatura_ancho = $miniatura_ancho_maximo;
					$miniatura_alto = $miniatura_alto_maximo;
				}
				
				$x = ( $miniatura_ancho - $miniatura_ancho_maximo ) / 2;
				$y = ( $miniatura_alto - $miniatura_alto_maximo ) / 2;
				
				switch ( $imagen_tipo ){
					case "image/jpg":
					case "image/jpeg":
						$imagen = imagecreatefromjpeg( $ruta_imagen );
						$url_logo=$_POST['id_pyme'].'_logo.jpg';
						break;
					case "image/png":
						$imagen = imagecreatefrompng( $ruta_imagen );
						$url_logo=$_POST['id_pyme'].'_logo.png';
						break;
					case "image/gif":
						$imagen = imagecreatefromgif( $ruta_imagen );
						$url_logo=$_POST['id_pyme'].'_logo.gif';
						break;
				}
				$id_pyme=$_POST['id_pyme'];
				$lienzo = imagecreatetruecolor( $miniatura_ancho_maximo, $miniatura_alto_maximo );
				$lienzo_temporal = imagecreatetruecolor( $miniatura_ancho, $miniatura_alto );
				
				imagecopyresampled($lienzo_temporal, $imagen, 0, 0, 0, 0, $miniatura_ancho, $miniatura_alto, $imagen_ancho, $imagen_alto);
				imagecopy($lienzo, $lienzo_temporal, 0,0, $x, $y, $miniatura_ancho_maximo, $miniatura_alto_maximo);
				
			
			$targetFolder2='/img/logos';
				$targetPath2 = $_SERVER['DOCUMENT_ROOT'] . $targetFolder2;
				$targetFile2 = rtrim($targetPath2,'/') . '/' . $url_logo;
				imagejpeg( $lienzo, $targetFile2, 100);
				
				$data=array(
						'nombre_foto'=>$url_logo);
				$update=new Empresa($this->dbAdapter);
				$update->updatePyme($id_pyme,$data);
				$mensaje=$url_logo;
				$bitacora = new Bitacora($this->dbAdapter);
				$bitacoraarray=array(
    					'id'=>'',
    					'descripcion'=>'update logo de empresa '.$id_pyme,
    					'user'=>$datos->us,
    					'fecha'=>date('Y-m-d H:i:s'),
    					'id_user'=>$datos->id_usuario
    			);
			} else {
				$mensaje='Invalid file type.';
			}
		}
		
	
	
		$layout = new ViewModel(array(
				'mensaje'=>$mensaje));
		$this->layout('layout/ajax');
		return $layout;
	}
	
	public function uploadbanner260Action(){
		/*
		 Uploadify
		Copyright (c) 2012 Reactive Apps, Ronnie Garcia
		Released under the MIT License <http://www.opensource.org/licenses/mit-license.php>
		*/
		$identi=$this->auth->getStorage()->read();
		if($identi!=false && $identi!=null){
			$datos=$identi;
		}
		else{
			$this->redirect()->toUrl($this->getRequest()->getBaseUrl().'/usuario/');
		}
	
		$this->dbAdapter=$this->getServiceLocator()->get('Zend\Db\Adapter');
	
		// Define a destination
		$targetFolder = '/uploads'; // Relative to the root
	
		$verifyToken = md5('unique_salt' . $_POST['timestamp']);
	
		if (!empty($_FILES) && $_POST['token'] == $verifyToken) {
			$tempFile = $_FILES['Filedata']['tmp_name'];
			$targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;
			$targetFile = rtrim($targetPath,'/') . '/' . $_FILES['Filedata']['name'];
	
			// Validate the file type
			$fileTypes = array('jpg','jpeg','gif','png'); // File extensions
			$fileParts = pathinfo($_FILES['Filedata']['name']);
	
			if (in_array($fileParts['extension'],$fileTypes)) {
				$tmpfoto=$_FILES['Filedata']['tmp_name'];
				move_uploaded_file($tempFile,$targetFile);
				$ruta_imagen=$targetFile;
				$miniatura_ancho_maximo = 260;
				$miniatura_alto_maximo = 260;
				$info_imagen = getimagesize($ruta_imagen);
				$imagen_ancho = $info_imagen[0];
				$imagen_alto = $info_imagen[1];
				$imagen_tipo = $info_imagen['mime'];
	
				$proporcion_imagen = $imagen_ancho / $imagen_alto;
				$proporcion_miniatura = $miniatura_ancho_maximo / $miniatura_alto_maximo;
	
				if ( $proporcion_imagen > $proporcion_miniatura ){
					$miniatura_ancho = $miniatura_alto_maximo * $proporcion_imagen;
					$miniatura_alto = $miniatura_alto_maximo;
				} else if ( $proporcion_imagen < $proporcion_miniatura ){
					$miniatura_ancho = $miniatura_ancho_maximo;
					$miniatura_alto = $miniatura_ancho_maximo / $proporcion_imagen;
				} else {
					$miniatura_ancho = $miniatura_ancho_maximo;
					$miniatura_alto = $miniatura_alto_maximo;
				}
	
				$x = ( $miniatura_ancho - $miniatura_ancho_maximo ) / 2;
				$y = ( $miniatura_alto - $miniatura_alto_maximo ) / 2;
	
				switch ( $imagen_tipo ){
					case "image/jpg":
					case "image/jpeg":
						$imagen = imagecreatefromjpeg( $ruta_imagen );
						$url_logo=$_POST['id_pyme'].'-banner260.jpg';
						break;
					case "image/png":
						$imagen = imagecreatefrompng( $ruta_imagen );
						$url_logo=$_POST['id_pyme'].'-banner260.png';
						break;
					case "image/gif":
						$imagen = imagecreatefromgif( $ruta_imagen );
						$url_logo=$_POST['id_pyme'].'-banner260.gif';
						break;
				}
				$id_pyme=$_POST['id_pyme'];
				$nombre=$_POST['nombre'];
				$lienzo = imagecreatetruecolor( $miniatura_ancho_maximo, $miniatura_alto_maximo );
				$lienzo_temporal = imagecreatetruecolor( $miniatura_ancho, $miniatura_alto );
	
				imagecopyresampled($lienzo_temporal, $imagen, 0, 0, 0, 0, $miniatura_ancho, $miniatura_alto, $imagen_ancho, $imagen_alto);
				imagecopy($lienzo, $lienzo_temporal, 0,0, $x, $y, $miniatura_ancho_maximo, $miniatura_alto_maximo);
	
					
				$targetFolder2='/img/banner/B260';
				$targetPath2 = $_SERVER['DOCUMENT_ROOT'] . $targetFolder2;
				$targetFile2 = rtrim($targetPath2,'/') . '/' . $url_logo;
				imagejpeg( $lienzo, $targetFile2, 100);
				if ($_POST['url_260']!=''){
					$data=array(
							'nombre_imagen'=>$url_logo,
							'id_empresa'=>$id_pyme
							);
					$bitacoraarray=array(
    					'id'=>'',
    					'descripcion'=>'actualización banner 260 empresa id: '.$id_pyme,
    					'user'=>$datos->us,
    					'fecha'=>date('Y-m-d H:i:s'),
    					'id_user'=>$datos->id_usuario
    			);
					$update= new Banner($this->dbAdapter);
					
					$update=$update->updateBanner($_POST['id_banner'], $data);
					$bitacora = new Bitacora($this->dbAdapter);
					$bitacora=$bitacora->insertar($bitacoraarray);
					$mensaje=$url_logo;
				}
				else {
					$idcategoria=$_POST['idcategoria'];
					$data=array(
							'id'=>'',
							'nombre_imagen'=>$url_logo,
							'id_empresa'=>$id_pyme,
							'categorias_disp'=>$idcategoria,
							'tipo'=>'T260'
					);
					$bitacoraarray=array(
    					'id'=>'',
    					'descripcion'=>'nuevo banner 260 empresa id: '.$id_pyme,
    					'user'=>$datos->us,
    					'fecha'=>date('Y-m-d H:i:s'),
    					'id_user'=>$datos->id_usuario
    			);
					$add= new Banner($this->dbAdapter);
					
					$add=$add->add($data);
					$bitacora = new Bitacora($this->dbAdapter);
					$bitacora=$bitacora->insertar($bitacoraarray);
					$mensaje=$url_logo;
					
				}
				
	
			} else {
				$mensaje='Invalid file type.';
			}
		}

	
		$layout = new ViewModel(array(
		'mensaje'=>$mensaje));
		$this->layout('layout/ajax');
		return $layout;
	}
	public function elegirAction(){
		$identi=$this->auth->getStorage()->read();
		if($identi!=false && $identi!=null){
			$nombre_usr=$identi->Nombre;
		}
		else{
			$this->redirect()->toUrl($this->getRequest()->getBaseUrl().'/usuario/');
		}
		$layout = new ViewModel(array(
				'nombre_usuario'=>$nombre_usr));
		$this->layout('layout/cpanel');
		return $layout;
	}
	public function nuevaAction(){
		$identi=$this->auth->getStorage()->read();
		$this->dbAdapter=$this->getServiceLocator()->get('Zend\Db\Adapter');
		if($identi!=false && $identi!=null){
			$transferencia= new Orders($this->dbAdapter);
			$transaccion=$transferencia->getOrderNull($identi->id_usuario);
			foreach ($transaccion as $transaccion) {
				$id_order=$transaccion['order_id'];
				$id_paquete=$transaccion['id_paquete'];
			}
			if ($id_paquete==1){
			return $this->forward()->dispatch('Usuario\Controller\Nueva',array('action' => 'basico','id_paquete'=>$id_paquete));
			}
		}else{
			$this->redirect()->toUrl($this->getRequest()->getBaseUrl().'/usuario/');
		}
		$layout = new ViewModel(array(
				'usuario'=>$identi->Nombre,
				'id_order'=>$id_order
		));
		$this->layout('layout/cpanel');
		return $layout;
	
	}
	
}


?>
