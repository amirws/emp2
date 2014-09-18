<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Empresa\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Empresa\Form\Search;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Sql;
use Zend\Db\Adapter\Adapter;
use Principal\Model\Entity\Busqueda;
use Principal\Model\Entity\Empresa;
use Zend\Mvc\Controller\Plugin;



class IndexController extends AbstractActionController
{
	public $dbAdapter;
    public function indexAction(){
    $this->dbAdapter=$this->getServiceLocator()->get('Zend\Db\Adapter');
    $url=$this->getEvent()->getRouteMatch()->getParam('url', 'default');
    $id = ereg_replace("[^0-9]", "", $url);
    $consultar= new Empresa($this->dbAdapter);
    $empresa=$consultar->getId($id);
    if (empty($empresa)){
        $status=0;
        $this->layout('layout/simple');
        return $this->notFoundAction();
    }
    else {

        $url_nuevo=$empresa->url;
        $response=$this->redirect()->toUrl("http://www.empresasveracruz.com.mx/".$url_nuevo)->setStatusCode(301);
         return $response;
    }
    	$layout =new ViewModel(array(
            'url'=>$url_nuevo,
            'status'=>$status));
    	$this->layout('layout/simple');
    	 return $layout;
    	 
    	 

    }
    
  public function redirectAction(){
  	$categoria=$this->request->getPost('search');
    $ciudad = $this->getRequest()->getPost('ciudad2');
  	$buscar = new Busqueda();
    if ($categoria=='' && $ciudad=='') {
       $categoria="en";
       $ciudad="Estado";
    }
    $buscar->setCategoria($categoria);
    $buscar->setCiudad($ciudad);
    $url_cat = $buscar->getUrl($categoria);
    $url_ciudad = $buscar->getUrl($ciudad);

    if($categoria!="" && $ciudad!=""){
         $this->redirect()->toUrl($this->getRequest()->getBaseUrl().'/'.$url_cat.'-'.$url_ciudad.'-Veracruz');
    }
    elseif ($categoria!="" && $ciudad==""){
        $this->redirect()->toUrl($this->getRequest()->getBaseUrl().'/'.$url_cat.'-en-Veracruz');
    }
    elseif ($categoria=="" && $ciudad!=""){
        $this->redirect()->toUrl($this->getRequest()->getBaseUrl().'/en-'.$url_ciudad.'-Veracruz');
    }
    elseif ($categoria=="en" && $ciudad=="Estado"){
        return $this->redirect()->toUrl($this->getRequest()->getBaseUrl().'/en-Estado-Veracruz');
    }
		else {

    return new ViewModel(array(
    		'titulo'=>'Redireccionar',
            'categoria'=>$url_cat,
            'ciudad'=>$ciudad
    		
    		));
    		}
	}

    
}
