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
            $authAdapter->setTableName('client_login')->setIdentityColumn('email')->setCredentialColumn('pass');
            $authAdapter->setIdentity($username)->setCredential($password);
            $auth = Zend_Auth::getInstance();
            $auth->authenticate($authAdapter);
        }
        if ($auth != Zend_Auth::getInstance()->hasIdentity()) {
            Zend_Auth::getInstance()->clearIdentity();
        }
        if (Zend_Auth::getInstance()->hasIdentity()) {
            $this->_redirect('/client/project');
        }
        $this->view->form = $form;
    }

    public function projectAction() {
        if (!Zend_Auth::getInstance()->hasIdentity()) {
            $this->_redirect('/client');
        }
        $form = new Application_Form_ClientForm();
        $auth = Zend_auth::getInstance()->hasIdentity();
        $user = Zend_auth::getInstance()->getIdentity($auth);
        $db = Zend_Db_Table::getDefaultAdapter();
        $select = $db->select()->from(array('report' => 'report'), array('report.title', 'report.date_added', 'report.added_by', 'report.assigned_to', 'report.attachment'))
                ->join(array('client_login' => 'client_login'), 'client_login.id=report.client_id', array())
                ->where("client_login.email='$user'");
        $show = $db->fetchAll($select);
        $this->view->show = $show;
        $this->view->form = $form;
    }

    public function taskAction() {
        if (!Zend_Auth::getInstance()->hasIdentity()) {
            $this->_redirect('/client');
        }
    }

    public function reportAction() {
        if (!Zend_Auth::getInstance()->hasIdentity()) {
            $this->_redirect('/client');
        }
        $form = new Application_Form_ReportForm();
        $auth = Zend_auth::getInstance()->hasIdentity();
        $user = Zend_auth::getInstance()->getIdentity($auth);
        $db = Zend_Db_Table::getDefaultAdapter();
        if ($this->_request->isPost() && $form->isValid($_POST)) {
            $data = $form->getValue('from');
            $db = Zend_Db_Table::getDefaultAdapter();
            $start = date('Y-m-d', strtotime($data));
            $data1 = $form->getValue('upto');
            $end = date('Y-m-d', strtotime($data1));
            $select = $db->select()
                    ->from(array('report' => 'report'), array('report.title', 'report.description', 'report.attachment'))
                    ->join(array('client_login' => 'client_login'), 'client_login.id=report.client_id', array())->where("client_login.email='$user'")
                    ->where("report.date_added>='$start' and report.date_added<='$end'");
            $show = $db->fetchAll($select);
            $this->view->show = $show;
        }
        $this->view->form = $form;
    }

}

?>