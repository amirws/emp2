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
use Empresa\Form\AddPyme;
use Empresa\Model\Entity\NewPyme;

class FormularioController extends AbstractActionController
{

    public function indexAction()
    {
    	return new ViewModel();

    }
    
    public function nuevaAction(){
    	$agregar = new AddPyme("addPyme");
    	$datos=new NewPyme($data=array('email'=>null,'nombre'=>null,'servicios'=>null));
    	$ciudades=$datos->seleccionarCiudad();
    	$agregar->get("ciudad")->setValueOptions($ciudades);
    	return new ViewModel(array('titulo'=>"Agregar Empresa",'form'=>$agregar,'url'=>$this->getRequest()->getBaseUrl()));
    }
    
    public function recibeAction(){
    	
    	$data=$this->request->getPost();
    	$procesa = new NewPyme($data);
    	$datos=$procesa->getData();
    return new ViewModel(array('datos'=>$datos));
    }
    
}
