<?php

class TeamController extends Zend_Controller_Action {

    public function init() {
        
    }

    public function indexAction() {
        $form = new Application_Form_TeamForm();
        $auth = "";
        if ($this->_request->isPost() && $form->isValid($_POST)) {
            $dbAdapter = Zend_Db_Table::getDefaultAdapter();
            $username = $form->getValue('name');
            $password = $form->getValue('pass');
            $authAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter);
            $authAdapter->setTableName('team')->setIdentityColumn('name')->setCredentialColumn('pass');
            $authAdapter->setIdentity($username)->setCredential($password);
            $auth = Zend_Auth::getInstance();
            $auth->authenticate($authAdapter);
        }
        if ($auth != Zend_Auth::getInstance()->hasIdentity()) {
            Zend_Auth::getInstance()->clearIdentity();
            $this->view->errors = $form->getMessages();
        }
        if (Zend_Auth::getInstance()->hasIdentity()) {
            $this->_redirect('/team/team');
        }

        $this->view->form = $form;
    }

    public function teamAction() {
        if (!Zend_Auth::getInstance()->hasIdentity()) {
            $this->_redirect('/team');
        }
        $form = new Application_Form_TeamForm();
        $model = new Application_Model_team();
        $data = $model->fetchAll();
        $this->view->data = $data;
        $this->view->form = $form;
    }

    public function forgotAction() {
        if (!Zend_Auth::getInstance()->hasIdentity()) {
            $this->_redirect('/team');
        }
        $form = new Application_Form_ForgotForm();
        $model = new Application_Model_team();
        $auth = Zend_auth::getInstance()->hasIdentity();
        $user = Zend_auth::getInstance()->getIdentity($auth);

        if ($this->_request->isPost() && $form->isValid($_POST)) {
            $pass = $form->getValues();
            $model->update(array('pass' => $pass['pass']), "name='$user'");
            $this->_redirect('/team/team');
        }
        $this->view->form = $form;
    }

    public function recoverAction() {
        $form = new Application_Form_EmailForm();
        $model = new Application_Model_team();
        $hash = substr(sha1(microtime()), 0, 6);
        $arr['pass'] = $hash;
        if ($this->_request->isPost() && $form->isValid($_POST)) {
            $data = $form->getValues();
            $id = $data['email'];
            $model->update($arr, "email='$id'");
            $smtpOptions = array('auth' => 'login', 'username' => 'oditverma@gmail.com', 'password' => 'Eddy@169318',
                'ssl' => 'ssl', 'port' => 465);
            $tr = new Zend_Mail_Transport_Smtp('smtp.gmail.com', $smtpOptions);
            Zend_Mail::setDefaultTransport($tr);
            $mail = new Zend_Mail();
            $mail->setBodyText(' Password change complete !' . 'Your new password is' . "$hash");
            $mail->setFrom('oditverma@gmail.com', 'Odit');
            $mail->addTo($id, 'fwd');
            $mail->addCc('oditverma@gmail.com', 'fwd');
            $mail->setSubject('TestSubject');
            $mail->send($tr);
            $this->_redirect('/team/forgot');
        }
        $this->view->form = $form;
    }

    public function updtAction() {
        $id = $this->_getParam('id');
        $form = new Application_Form_UpdtForm();
        $form->removeElement('pass');
        $model = new Application_Model_team();
        $result = $model->fetchrow("id='$id'");
        $form->populate($result->toArray());
        if ($this->_request->isPost() && $form->isValid($_POST)) {
            $data = $form->getValues();
            $model->update($data, "id='$id'");
            $this->_redirect('/team/team');
        }
        $this->view->form = $form;
    }

    public function delAction() {
        $id = $this->_getParam('id');
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->layout->disableLayout();
        if (empty($id)) {
            throw new Exception('ID not provided');
        }
        if (!empty($id)) {
            $row = new Application_Model_team();
            $row->delete("id='$id'");
            $this->_redirect('/team/team');
        }
    }

    public function editAction() {
        if (!Zend_Auth::getInstance()->hasIdentity()) {
            $this->_redirect('/team');
        }
        $form = new Application_Form_UpdtForm();
        $form->removeElement('id');
        if ($this->_request->isPost() && $form->isValid($_POST)) {
            $row = new Application_Model_team();
            $data = $form->getValues();
            $row->insert($data);
            $this->_redirect('/team/team');
            $this->view->data = $data;
        }
        $this->view->form = $form;
    }

}

?>