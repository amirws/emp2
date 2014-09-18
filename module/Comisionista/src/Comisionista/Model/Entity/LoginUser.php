<?php
/**
 * Created by JetBrains PhpStorm.
 * User: martin
 * Date: 21/09/13
 * Time: 10:30
 * To change this template use File | Settings | File Templates.
 */

namespace Comisionista\Model\Entity;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable as AuthAdapter;
use Zend\Authentication\Result;

class LoginUser{

    private $auth;
    private $authAdapter;
    const NOT_IDENTITY = 'notIdentity';
    const INVALID_CREDENTIAL = 'invalidCredential';
    const INVALID_USER = 'invalidUser';
    const INVALID_LOGIN = 'invalidLogin';

    protected $_messages = array(
        self::NOT_IDENTITY => "No existe el usuario. A record with the supplied identity could not be found.",
        self::INVALID_CREDENTIAL => "Contraseña Incorrecta. Supplied credential is invalid.",
        self::INVALID_USER => "Invalid User. Supplied credential is invalid",
        self::INVALID_LOGIN => "Invalid Login. Fields are empty"
    );

    public function __construct($dbAdapter, $table, $usuario, $pass) {
        $this->authAdapter = new AuthAdapter($dbAdapter, $table, $usuario, $pass);
        $this->auth = new AuthenticationService();
    }

    // Login
    public function login($us, $password) {

        if (!empty($us) && !empty($password)) {

            $password = $password; // encrypt password

            $this->authAdapter->setIdentity($us);
            $this->authAdapter->setCredential($password);
            $result = $this->auth->authenticate($this->authAdapter);

            switch ($result->getCode()) {
                case Result::FAILURE_IDENTITY_NOT_FOUND:
                    throw new \Exception($this->_messages[self::NOT_IDENTITY]);
                    break;
                case Result::FAILURE_CREDENTIAL_INVALID:
                    throw new \Exception($this->_messages[self::INVALID_CREDENTIAL]);
                    break;
                case Result::SUCCESS:
                    if ($result->isValid()) {
                        $data = $this->authAdapter->getResultRowObject();
                        $this->auth->getStorage()->write($data);
                    } else {
                        throw new \Exception($this->_messages[self::INVALID_USER]);
                    }
                break;
                default:
                    throw new \Exception($this->_messages[self::INVALID_LOGIN]);
                break;
            }

        } else {
            throw new \Exception($this->_messages[self::INVALID_LOGIN]);
        }

            return $this;

    }

    //Logout
    public function logout() {
        $this->auth->clearIdentity();
        return $this;
    }

    public function getIdentity() {
        if ($this->auth->hasIdentity()) {
            return $this->auth->getIdentity();
        }
        return null;
    }

    public function isLoggedIn() {
        return $this->auth->hasIdentity();
    }


    public function setMessage($messageString, $messageKey = null) {

        if ($messageKey === null) {
            $keys = array_keys($this->_messages);
            $messageKey = current($keys);
        }

        if (!isset($this->_messages[$messageKey])) {
            throw new \Exception("No message exists for key '$messageKey'");
        }

        $this->_messages[$messageKey] = $messageString;
        return $this;

    }

    public function setMessages(array $messages) {
        foreach ($messages as $key => $message) {
            $this->setMessage($message, $key);
        }
        return $this;
    }

   }