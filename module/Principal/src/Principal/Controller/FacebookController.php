<?php
/**
 * Zend Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @category   Zend
 * @package    controller
 * @subpackage Facebook
 * @copyright  Copyright (c) 2005-2010 PHPSA . (http://www.phpsa.co.za)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id: FacebookController.php 
 */
namespace Principal\Controller;
use Zend\Mvc\Controller\AbstractActionController;
class FacebookController Extends AbstractActionController{
    //put your code here

    public function indexAction(){
        $Application_Id = "116382088396502";
        $Application_Security = "3915e15e04786f9bd235855a15842f67";
        $CallBack = "window.location=\"".$this->view->url(array('module'=>'default','controller'=>'Facebook','action'=>'login'))."\";";
        $Permissions = "email"; // explain ur permission like offline_status, email,sms etc http://developers.facebook.com/docs/authentication/permissions.
        $this->view->facebook = new Facebook_Api($Application_Id,$Application_Security,$Permissions,$CallBack);
    }

    public function loginAction(){
        //put your login functionality here for your system
        $this->_forward('index');
    }

    public function logoutAction(){
        //put your logout functionality here for your system
        $this->_forward('index');
    }
}
?>
