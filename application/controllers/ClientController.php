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
        }
        if (Zend_Auth::getInstance()->hasIdentity()) {
            $this->_redirect('/client/task');
        }
        $this->view->form = $form;
    }

    public function dashAction() {
        
    }

    public function taskAction() {
        if (!Zend_Auth::getInstance()->hasIdentity()) {
            $this->_redirect('/client');
        }
        $form = new Application_Form_ClientForm();
        $auth = Zend_auth::getInstance()->hasIdentity();
        $user = Zend_auth::getInstance()->getIdentity($auth);
        $db = Zend_Db_Table::getDefaultAdapter();
        $select = $db->select()->from(array('task' => 'task'), array('task.title', 'task.description', 'task.date_added', 'task.status', 'task.attachment'))
                        ->join(array('client' => 'client'), 'client.id=task.client_id', array())->where("client.name='$user'");
        $show = $db->fetchAll($select);
        $this->view->show = $show;
        $this->view->form = $form;
    }

}

?>