<?php

class ClientController extends Zend_Controller_Action {

    public function init() {
        /*  $auth = Zend_auth::getInstance();
          if ($auth != Zend_Auth::getInstance()->hasIdentity()) {
          Zend_Auth::getInstance()->clearIdentity();
          $this->_redirect('/user');
          } */
    }

    public function indexAction() {
        $form = new Application_Form_ClientForm();
        $auth = "";
        if ($this->_request->isPost() && $form->isValid($_POST)) {
            $dbAdapter = Zend_Db_Table::getDefaultAdapter();
            $username = $form->getValue('Cname');
            $password = $form->getValue('pass');
            $authAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter);
            $authAdapter->setTableName('client')->setIdentityColumn('name')->setCredentialColumn('pass');
            $authAdapter->setIdentity($username)->setCredential($password);
            $auth = Zend_Auth::getInstance();
            $auth->authenticate($authAdapter);
        }
        if ($auth != Zend_Auth::getInstance()->hasIdentity()) {
            Zend_Auth::getInstance()->clearIdentity();
            $this->view->errors = $form->getMessages();
        }
        if (Zend_Auth::getInstance()->hasIdentity()) {
            $this->_redirect('/client/task');
        }
        $this->view->form = $form;
    }

    public function dashAction() {
        
    }

    public function taskAction() {
        $form = new Application_Form_ClientForm();
        $model = new Application_Model_task();
        $auth = Zend_auth::getInstance()->hasIdentity();
        $user = Zend_auth::getInstance()->getIdentity($auth);
        if ($this->_request->isPost() && $form->isValid($_POST)) {
            $show = $model->fetchAll("name='$user'");
            $this->view->show = $show;
        }
    }

}

?>