<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Empresa\Form\Search;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Sql;
use Zend\Db\Adapter\Adapter;
use Principal\Model\Entity\Busqueda;
use Principal\Model\Entity\Empresa;
use Zend\Mvc\Controller\Plugin;
use Zend\View\Model\JsonModel;


class IndexController extends AbstractActionController
{
    public function indexAction(){
    	
    $categoria=$this->request->getPost('search');
    $ciudad = $this->request->getPost('ciudad2');
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
        
         $mensaje= $this->getRequest()->getBaseUrl().'/'.$url_cat.'-'.$url_ciudad.'-Veracruz';
         $url = new JsonModel(array('url'=>$mensaje));
         return $url;
    }
    else if ($categoria!="" && $ciudad==""){
        $var= $this->getRequest()->getBaseUrl().'/'.$url_cat.'-en-Veracruz';
         $url = new JsonModel(array('url'=>$var));
         return $url;
    }
    elseif ($categoria=="" && $ciudad!=""){
        $var = $this->getRequest()->getBaseUrl().'/en-'.$url_ciudad.'-Veracruz';
       $url = new JsonModel(array('url'=>$var));
         return $url;
    } 
    elseif ($categoria=="en" && $ciudad=="Estado"){
        $var= $this->getRequest()->getBaseUrl().'/en-Estado-Veracruz';
        $url = new JsonModel(array('url'=>$var));
         return $url;
    }
    else {

    return new ViewModel(array(
    		'titulo'=>'Redireccionar',
            'categoria'=>$var,
            'ciudad'=>$ciudad
    		
    		));
    		
	}
}
}
