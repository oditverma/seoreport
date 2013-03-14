<?php

class ProjectController extends Zend_Controller_Action {

    protected $_projectFrom = Null;
    protected $_projectModel = Null;

    protected function _getProjectModel() {
        if (!$this->_projectModel instanceof Application_Model_project) {
            $this->_projectModel = new Application_Model_project();
        }
        return $this->_projectModel;
    }

    protected function _getProjectForm() {
        if (!$this->_projectFrom instanceof Application_Form_ProjectForm) {
            $this->_projectForm = new Application_Form_ProjectForm();
        }
        return $this->_projectForm;
    }

    public function init() {
        $auth = Zend_auth::getInstance();
        if ($auth != Zend_Auth::getInstance()->hasIdentity()) {
            Zend_Auth::getInstance()->clearIdentity();
            $this->_redirect('/index');
        }
    }

    public function indexAction() {
        $row = $this->_getProjectModel();
        $data = $row->fetchAll('status=1');
        $this->view->data = $data;
    }

    public function deleteAction() {
        $id = $this->_getParam('id');
        $form = $this->_getProjectForm();
        if (!empty($id)) {
            $row = $this->_getProjectModel();
            $row->delete("id='$id'");
        }
        $this->view->form = $form;
        $this->_redirect('/project/index');
    }

    public function updateAction() {
        $id = $this->_getParam('id');
        $form = $this->_getProjectForm();
        $model = $this->_getProjectModel();
        $result = $model->fetchrow("id='$id'");
        $form->populate($result->toArray());
        if ($this->_request->isPost() && $form->isValid($_POST)) {
            $data = $form->getValues();
            $model->update($data, "id='$id'");
            $this->_redirect('/project/index');
        }
        $this->view->form = $form;
    }

    public function editAction() {
        $form = $this->_getProjectForm();
        if ($this->_request->isPost() && $form->isValid($_POST)) {
            $row = $this->_getProjectModel();
            $data = $form->getValues();
            $start = date('Y-m-d', strtotime($data['date_added']));
            $this->_getProjectModel()->insert(array('title' => $data['title'],
                'description' => sha1($data['description']),
                'date_added' => $start,
                'attachment' => $data['attachment'],
                'user_id' => $data['user_id']));
            $this->_redirect('/project/index');
            $this->view->row = $row;
        }
        $this->view->form = $form;
    }

    public function statusAction() {
        $id = $this->_getParam('id');
        $model = $this->_getProjectModel();
        $arr = array('status' => '0');
        $model->update($arr, 'id=' . $id);
        $this->_redirect('/project/index');
    }

    public function keywordAction() {
        $form = new Application_Form_KeywordForm();
        if ($this->_request->isPost() && $form->isValid($_POST)) {
            $row = new Application_Model_keyword();
            $data = $form->getValues();
            $row->insert($data);
            $this->_redirect('/project/keyword');
        }
        $row = new Application_Model_keyword();
        $select = $row->fetchAll();
        $this->view->select = $select;
        $this->view->form = $form;
    }

    public function keydelAction() {
        $id = $this->_getParam('id');
        $form = new Application_Form_KeywordForm();
        if (!empty($id)) {
            $row = new Application_Model_keyword();
            $row->delete("id='$id'");
        }
        $this->view->form = $form;
        $this->_redirect('/project/keyword');
    }

    public function keyupdtAction() {
        $id = $this->_getParam('id');
        $model = new Application_Model_keyword();
        $form = new Application_Form_KeywordForm();
        if ($this->_request->isPost() && $form->isValid($_POST)) {
            $result = $model->fetchrow("id='$id'");
            $form->populate($result->toArray());
            
            $this->_redirect('/project/keyword');
        }
        $this->view->form = $form;
    }

    public function resourceAction() {
        
    }

}

?>