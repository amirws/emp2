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
use Empresa\Model\Entity\Empresa;

class VeracruzController extends AbstractActionController
{

    public function indexAction()
    {
    	$m = new Empresa();
    	$empresa=$m->getNombre();
    	$fotos=$m->getFotos();
    	return new ViewModel(array('empresa'=>$empresa,'fotos'=>$fotos));
    

    }
    public function empresaAction()
    {
    	$m = new Empresa("Este es un parametro por controlador");
    	$empresa=$m->getNombre();
    	$fotos=$m->getFotos();
    	$valor=$m->desdeController();
    	return new ViewModel(array('empresa'=>$empresa,'fotos'=>$fotos,'valor'=>$valor));
    }
    
   
    
}
