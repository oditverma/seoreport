<?php

class IndexController extends Zend_Controller_Action {

    public function init() {
        
    }

    public function indexAction() {
        
    }

    public function loginAction() {

        $form = new Application_Form_IndexForm();
        $this->view->form = $form;
        if ($this->_request->isPost() && $form->isValid($_POST)) {
            $data = $form->getValues();
            $db = Zend_Db_Table::getDefaultAdapter();
            $authAdapter = new Zend_Auth_Adapter_DbTable($db, 'user', 'name', 'pass');
            $authAdapter->setIdentity($data['name'])->setCredential($data['pass']);
            $auth = Zend_Auth::getInstance();
            $auth->authenticate($authAdapter);
            $storage = $auth->getStorage();
            $userInfo = $authAdapter->getResultRowObject(array('name', 'id', 'account_type', 'status', 'email', 'address'));
            $storage->write($userInfo);
            $type = $auth->getIdentity()->account_type;
            $status = $auth->getIdentity()->status;
            if ($type == 'admin' && $status == TRUE) {
                $this->_redirect('/admin/index');
            }
            if ($type == 'client' && $status == TRUE) {
                $this->_redirect('/client/index');
            }
            if ($type == 'team' && $status == TRUE) {
                $this->_redirect('/team/index');
            } else {
                echo "<script>bootbox.alert('incorrect');</script>";
            }
        }
    }

    public function logoutAction() {
        $authAdapter = Zend_Auth::getInstance();
        $authAdapter->clearIdentity();
        $this->_redirect('/index');
    }

}
