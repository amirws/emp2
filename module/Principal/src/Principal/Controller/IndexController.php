<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Principal\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Sql;
use Zend\Db\Adapter\Adapter;
use Principal\Model\Entity\Empresa;
use Principal\Model\Entity\Municipio;
use Principal\Model\Entity\Cupon;
use Principal\Model\Entity\Banner;
use Principal\Form\Search;
use Principal\Form\Usuario;




class IndexController extends AbstractActionController
{
	public $dbAdapter;
    public function indexAction()
    { 
    	$this->dbAdapter=$this->getServiceLocator()->get('Zend\Db\Adapter');
    	$empresas=$this->dbAdapter->query("SELECT * FROM empresa INNER JOIN categoria ON empresa.idcategoria = categoria.idcategoria WHERE Activa = 'si' order by empresa.id desc ", Adapter::QUERY_MODE_EXECUTE);
    	$logos = $this->dbAdapter->query("SELECT nombre, nombre_foto, url FROM empresa WHERE Activa = 'si' && nombre_foto<>'sin_imagen.gif' && paquete>0 order by rand() limit 45 ", Adapter::QUERY_MODE_EXECUTE);
        $form = new Search('search');
    	$cupones = new Cupon($this->dbAdapter);
    	$formRegistro= new Usuario('registro');
    	$categorias=$this->dbAdapter->query("SELECT * FROM categoria order by nombre_categoria Asc ", Adapter::QUERY_MODE_EXECUTE);
    	$municipios = new Municipio($this->dbAdapter);
        $muni=$municipios->getMunicipios();
    	$datos=array();
        foreach ($muni as $row) {
            $datos[$row->url_m] = $row->nombre_m;
        }
        $layout = new ViewModel(array(
    	 		'empresas' => $empresas,
    			'cupones' => $cupones->getCupones(),
                'municipios'=>$datos,
                'directorios'=>$municipios->getMunicipios(),
    			'categorias'=> $categorias,
                'logos'=>$logos
    	 		));
    	 $this->layout('layout/index');
    	 $layout->setVariable('form',$form);
    	 $layout->setVariable('formRegistro',$formRegistro);
    	 return $layout;

    }
    public function ajaxAction (){
        $this->dbAdapter=$this->getServiceLocator()->get('Zend\Db\Adapter');
        $banner240=$this->dbAdapter->query("SELECT * FROM empresa INNER JOIN anuncios ON empresa.id = anuncios.id_empresa WHERE Activa = 'si' && tipo='T260' order by rand() limit 1 ", Adapter::QUERY_MODE_EXECUTE);
        $titulo="esta es una prueba";
        $layout = new ViewModel(array(
            'pyme' => $banner240 ));
    	$this->layout('layout/ajax');
        return $layout;
    }
    public function getbanner240catAction (){
        $categoria=htmlentities($this->params()->fromRoute('categoria','0'));
        $this->dbAdapter=$this->getServiceLocator()->get('Zend\Db\Adapter');
        if ($categoria==0){
            $categoria='';
        $banners=$this->dbAdapter->query("SELECT * FROM empresa INNER JOIN anuncios ON empresa.id = anuncios.id_empresa WHERE empresa.Activa = 'si' && anuncios.tipo='T260' && anuncios.idcategoria =NULL order by rand() limit 1 ", Adapter::QUERY_MODE_EXECUTE);
    }
    else{
        $banners=$this->dbAdapter->query("SELECT * FROM empresa INNER JOIN anuncios ON empresa.id = anuncios.id_empresa WHERE empresa.Activa = 'si' && anuncios.tipo='T260' && (anuncios.idcategoria=$categoria) order by rand() limit 1 ", Adapter::QUERY_MODE_EXECUTE);
    }
    if (count($banners)==0) {
                $categoria='';
                $banners=$this->dbAdapter->query("SELECT * FROM empresa INNER JOIN anuncios ON empresa.id = anuncios.id_empresa WHERE empresa.Activa = 'si' && anuncios.tipo='T260' && anuncios.idcategoria= '$categoria' order by rand() limit 1 ", Adapter::QUERY_MODE_EXECUTE);
            }

            $i=count($banners);
        $layout = new ViewModel(array(
            'banner' => $banners,
            'categoria'=>$categoria,
            'i'=>$i

            ));
        $this->layout('layout/ajax');
        return $layout;
    }
 
 

    
}