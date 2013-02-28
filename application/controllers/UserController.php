<?php

class UserController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    public function indexAction() {
        $form = new Application_Form_UserForm();
        $auth = "";
        if ($this->_request->isPost() && $form->isValid($_POST)) {
            $dbAdapter = Zend_Db_Table::getDefaultAdapter();
            $username = $form->getValue('name');
            $password = $form->getValue('pass');
            $authAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter);
            $authAdapter->setTableName('admin')->setIdentityColumn('name')->setCredentialColumn('pass');
            $authAdapter->setIdentity($username)->setCredential($password);
            $auth = Zend_Auth::getInstance();
            $auth->authenticate($authAdapter);
        }
        if ($auth != Zend_Auth::getInstance()->hasIdentity()) {
            Zend_Auth::getInstance()->clearIdentity();
$this->view->errors=$form->getMessages();
        }
        if (Zend_Auth::getInstance()->hasIdentity()) {
            $this->_redirect('/admin/index');
        }
        
        $this->view->form = $form;
    }

}

?>
