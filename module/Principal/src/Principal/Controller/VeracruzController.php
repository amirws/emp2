<?php

/**
 * {0}
 * 
 * @author
 * @version 
 */
namespace Principal\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Principal\Model\Entity\Busqueda;
use Principal\Model\Entity\Municipio;
use Principal\Model\Entity\Categoria;
use Principal\Model\Entity\Cupon;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Sql;
use Zend\Db\Adapter\Adapter;
use Principal\Form\Search;


class VeracruzController extends AbstractActionController
{
    public $idcategoria="";
	public $dbAdapter;
    public function indexAction() 
    {
 		$this->dbAdapter=$this->getServiceLocator()->get('Zend\Db\Adapter');
    	$ciudad=$this->getEvent()->getRouteMatch()->getParam('ciudad', 'default');
    	$categoria=$this->getEvent()->getRouteMatch()->getParam('categoria', 'default');
        $municipio = new Municipio($this->dbAdapter);
        $ciudad_search=$municipio->getMunicipioUrl(htmlentities($ciudad));
        foreach ($ciudad_search as $value) {
        $ciudad=$value['nombre_m'];
        $url_ciudad=$value['url_m'];
        }
        $muni=$municipio->getMunicipios();
        $datos=array();
        foreach ($muni as $row) {
            $datos[$row->url_m] = $row->nombre_m;
        }
        @session_start();
        $url_cat=$categoria;
        $categoria = str_replace("-"," ",$categoria);

        if ($categoria=="Diseno Web")
            {$categoria="Diseño Web"; $_SESSION['cat']="Diseño Web"; 
            } elseif ($categoria=="Diseno de Interiores") {
            $categoria="Diseño de Interiores"; $_SESSION['cat']="Diseño de Interiores";
            } elseif ($categoria=="Diseno Grafico") {
            $categoria="Diseño Gráfico"; $_SESSION['cat']="Diseño Gráfico";
            } elseif ($categoria=="Casas de Empeno") {
            $categoria="Casas de Empeño"; $_SESSION['cat']="Casas de Empeño";
            }
            elseif ($categoria=="Sexologos") {
            $categoria="Sexólogos"; $_SESSION['cat']="Sexólogos";
            }

        if ($ciudad=='Estado') {
           $ciudad="";
        } if ($ciudad=='en') {
           $ciudad="";
        }
        if ($categoria=='en') {
           $categoria2=""; $categoria="";
           $datas=array();
           $categorias=new Categoria($this->dbAdapter);
           $categories=$categorias->getCategorias();
       }
        @$cat2=strlen($_SESSION['cat'])-1;
        if (strlen($categoria)!=$cat2) {
            $categoria2=$categoria;
            @session_destroy($_SESSION['cat']);
        }
        else{
                $categoria2=$_SESSION['cat'];
                @session_destroy($_SESSION['cat']); 
            }


    	if ($ciudad=="" && $categoria !=''){ 
    	$empresas=$this->dbAdapter->query("SELECT * FROM empresa INNER JOIN categoria ON empresa.idcategoria = categoria.idcategoria WHERE Activa = 'si' && (categoria.nombre_categoria LIKE '%$categoria2%' || empresa.Servicios LIKE '%$categoria2%' || categoria.claves LIKE '%$categoria2%') order by empresa.id desc ", Adapter::QUERY_MODE_EXECUTE);
        $categ=$this->dbAdapter->query("SELECT * FROM categoria WHERE nombre_categoria LIKE '%$categoria2%' OR  claves LIKE '%$categoria2%' LIMIT 1 ", Adapter::QUERY_MODE_EXECUTE);
        $key="";
        $titulo = "$categoria2 Veracruz | $categoria2 en Veracruz :: EmpresasVeracruz.Com.Mx";
        foreach ($categ as $cat) {

            $descripcion = 'Encuentra '.$cat['nombre_categoria'].' en Veracruz. Especialistas en '.$cat['nombre_categoria']. ' en Veracruz. Empresas '.$cat['nombre_categoria'].' en el Estado de Veracruz. ¿Aún no esta tu empresa aquí?';
            $key = $key.''.$cat['nombre_categoria'].', ';
            $key = $key.''.$cat['nombre_categoria'].' en Veracruz, ';
            $key = $key.''.$cat['nombre_categoria'].' veracruz';
            $claves = $cat['claves'];
            $claves= explode(",", $claves);
            foreach ($claves as $clave) {
                $key = $key.', '.$clave;
                $key = $key.', '.$clave.' en veracruz';
            }
             $categoria2=$cat['nombre_categoria'];
             $idcategoria=$cat['idcategoria'];
        }

        }

    	elseif ($categoria=="" && $ciudad !=''){ 
        $categoria='';
        $empresas=$this->dbAdapter->query("SELECT * FROM empresa INNER JOIN categoria ON empresa.idcategoria = categoria.idcategoria WHERE Activa = 'si' && empresa.Ciudad LIKE '%$ciudad%' order by empresa.id desc ", Adapter::QUERY_MODE_EXECUTE);
        $categoria2=$categoria;
        $idcategoria='';
        $titulo = "Empresas en $ciudad | Empresas $ciudad :: EmpresasVeracruz.Com.Mx";
        $banners=$this->dbAdapter->query("SELECT * FROM anuncios WHERE idcategoria LIKE '%$idcategoria%' or idcategoria = null LIMIT 1 ", Adapter::QUERY_MODE_EXECUTE);

            @$descripcion= "Directorio de Empresas en $ciudad. Encuentra las mejores empresas de $ciudad. Todos los giros comerciales. Pequeñas medianas y grandes empresas. ¡Anunciate Aquí!";
            $key = "Empresas en $ciudad, empresas $ciudad veracruz, directorio de empresas en $ciudad, directorio en $ciudad veracruz, empresas $ciudad veracruz, guia de empresas en $ciudad, lista de empresas en $ciudad, directorio $ciudad";
        
        }
    
    	elseif ($categoria=="" && $ciudad ==''){
    		$empresas=$this->dbAdapter->query("SELECT * FROM empresa INNER JOIN categoria ON empresa.idcategoria = categoria.idcategoria WHERE Activa = 'si' order by empresa.id desc ", Adapter::QUERY_MODE_EXECUTE);
            $categoria='';
            $categoria2=$categoria;
            $idcategoria='';
             $titulo = "Empresas en Veracruz :: EmpresasVeracruz.Com.Mx";
        $banners=$this->dbAdapter->query("SELECT * FROM anuncios WHERE idcategoria LIKE '%$idcategoria%' or idcategoria = null  LIMIT 1 ", Adapter::QUERY_MODE_EXECUTE);
            @$descripcion= "Directorio de empresas en VERACRUZ, GUÍA DE EMPRESAS el el Estado de Veracruz, las mejores empresas de veracruz, lista empresarial, todos los sectores y/o giros comerciales";
            $key = "empresas, veracruz, pymes veracruz, empresarial veracruz, guia empresarial veracruz, empresas.";
        }
        else {
            $empresas=$this->dbAdapter->query("SELECT * FROM empresa INNER JOIN categoria ON empresa.idcategoria = categoria.idcategoria WHERE Activa = 'si' && empresa.Ciudad LIKE '%$ciudad%' && (categoria.nombre_categoria LIKE '%$categoria%' || categoria.claves LIKE '%$categoria%') order by empresa.id desc ", Adapter::QUERY_MODE_EXECUTE);
            $categ=$this->dbAdapter->query("SELECT * FROM categoria WHERE nombre_categoria LIKE '%$categoria2%' OR  claves LIKE '%$categoria2%' LIMIT 1 ", Adapter::QUERY_MODE_EXECUTE);
            $key="";

            foreach ($categ as $cat) {
            $descripcion = 'Encuentra '.$cat['nombre_categoria'].' en '.$ciudad.' Veracruz. Especialistas en '.$cat['nombre_categoria']. ' en Veracruz. Empresas '.$cat['nombre_categoria'].' en el Estado de Veracruz. ¿Aún no esta tu empresa aquí?';
            $key = $key.''.$cat['nombre_categoria'].' '.$ciudad.', ';
            $key = $key.''.$cat['nombre_categoria'].' en '.$ciudad.', ';
            $key = $key.''.$cat['nombre_categoria'].' en '.$ciudad.' veracruz';
            $claves = $cat['claves'];
            $claves= explode(",", $claves);
            foreach ($claves as $clave) {
                $key = $key.', '.$clave;
                $key = $key.', '.$clave.' en '.$ciudad ;

            }
            $categoria2=$cat['nombre_categoria'];
             $idcategoria=$cat['idcategoria'];
             $banners=$this->dbAdapter->query("SELECT * FROM anuncios WHERE idcategoria LIKE '%$idcategoria%' or idcategoria = null  LIMIT 1 ", Adapter::QUERY_MODE_EXECUTE);
              $titulo = "$categoria2 en $ciudad .:: EmpresasVeracruz.Com.Mx";
            }

        }



    	
    	$form= new Search('Search');
        $cu= new Cupon($this->dbAdapter);
        $cupones=$cu->getCuponesCat(@$idcategoria);
        if(count($cupones)==0){
            $cupones=$cu->getCupones();
        }

    	$busqueda = new ViewModel(array(
       		'titulo'=>@$titulo,
    		'empresas'=>$empresas,
            'form'=>$form,
            'categoria'=>@$categoria2,
            'ciudad'=>$ciudad,
            'keys' => @$key,
            'descripcion' => @$descripcion,
            'url_cat' =>$url_cat,
            'url_ciudad' =>@$url_ciudad,
            'banners' => @$banners,
            'municipios'=>$datos,
            'idcategoria'=>@$idcategoria,
            'ciudades'=>$municipio->getMunicipios(),
            'cupones' => $cupones,
            'categorias'=>@$categories
       		));
    	$this->layout('layout/busqueda');
    	return $busqueda;
      
    }
    
}
