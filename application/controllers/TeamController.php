<?php

class TeamController extends Zend_Controller_Action {

    public function init() {
        $auth = Zend_Auth::getInstance();
        $type = $auth->getIdentity()->account_type;
        if (!$auth->hasIdentity()) {
            Zend_Auth::getInstance()->clearIdentity();
            $this->_redirect('/index');
        } else if ($type == 'Admin' || $type == 'Client') {
            Zend_Auth::getInstance()->clearIdentity();
            $this->_redirect('/index');
        }
    }

    public function indexAction() {
        if (!Zend_Auth::getInstance()->hasIdentity()) {
            $this->_redirect('/index');
        }
    }

    public function teamAction() {
        $auth = Zend_Auth::getInstance();
        $id = $auth->getIdentity()->id;
        $db = Zend_Db_Table::getDefaultAdapter();
        $select = $db->select()->from(array('report' => 'report'), array('report.id', 'report.title', 'report.added_by', 'report.assign_to', 'report.time_added', 'report.attachment'))
                ->join(array('project' => 'project'), 'project.id=report.project_id', array())
                ->where("project.user_id='$id'");
        $show = $db->fetchAll($select);
        $this->view->show = $show;
    }

    public function forgotAction() {

        $form = new Application_Form_ForgotForm();
        $model = new Application_Model_admin();
        $auth = Zend_Auth::getInstance();
        $id = $auth->getIdentity()->id;
        if ($this->_request->isPost() && $form->isValid($_POST)) {
            $pass = $form->getValues();
            $model->update(array('pass' => $pass['pass']), "id='$id'");
            $this->_redirect('/team/index');
        }
        $this->view->form = $form;
    }

    public function updtAction() {
        $id = $this->_getParam('id');
        $form = new Application_Form_TaskForm();
        $model = new Application_Model_report();
        $result = $model->fetchRow("project_id='$id'");
        $form->populate($result->toArray());
        if ($this->_request->isPost() && $form->isValid($_POST)) {
            $data = $form->getValues();
            $model->update($data, "id='$id'");
            $this->_redirect('/team/report/id/' . $id);
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
        $form = new Application_Form_TaskForm();
        if ($this->_request->isPost() && $form->isValid($_POST)) {
            $row = new Application_Model_report();
            $data = $form->getValues();
            $row->insert($data);
            $this->_redirect('/team/index');
            $this->view->data = $data;
        }
        $this->view->form = $form;
    }

    public function profileAction() {
        $auth = Zend_auth::getInstance();
        $id = $auth->getIdentity()->id;
        $form = new Application_Form_ProfileForm();
        $model = new Application_Model_admin();
        $result = $model->fetchrow("id='$id'");
        $form->populate($result->toArray());
        if ($this->_request->isPost() && $form->isValid($_POST)) {
            $data = $form->getValues();
            $model->update($data, "id='$id'");
            $this->_redirect('/team/index');
        }
        $this->view->form = $form;
    }

    public function projectAction() {
        $model = new Application_Model_project();
        $row = $model->fetchAll();
        $this->view->row = $row;
    }

    public function reportAction() {
        $id = $this->_getParam('id');
        $model = new Application_Model_report();
        $row = $model->fetchAll("project_id='$id'");
        $this->view->row = $row;
    }

    public function logoutAction() {
        $authAdapter = Zend_Auth::getInstance();
        $authAdapter->clearIdentity();
        $this->_redirect('/index/login');
    }

}

?>