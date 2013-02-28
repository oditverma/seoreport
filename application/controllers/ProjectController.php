<?php

class ProjectController extends Zend_Controller_Action {

    public function init() {
        $auth = Zend_auth::getInstance();
        if ($auth != Zend_Auth::getInstance()->hasIdentity()) {
            Zend_Auth::getInstance()->clearIdentity();
            $this->_redirect('/user');
        }
    }

    public function indexAction() {
        $form = new Application_Form_ProjectForm();
        $row = new Application_Model_project();
        $data = $row->fetchAll('status=1');
        $this->view->data = $data;
        $this->view->form = $form;
    }

    public function deleteAction() {
        $id = $this->_getParam('id');
        $form = new Application_Form_ProjectForm();
        if (!empty($id)) {
            $row = new Application_Model_project();
            $row->delete("id='$id'");
        }
        $this->view->form = $form;
        $this->_redirect('/project/index');
    }

    public function updateAction() {
        $id = $this->_getParam('id');
        $form = new Application_Form_ProjectForm();
        $model = new Application_Model_project();
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
        $form = new Application_Form_ProjectForm();
        if ($this->_request->isPost() && $form->isValid($_POST)) {
            $row = new Application_Model_project();
            $data = $form->getValues();
            $row->insert($data);
            $this->_redirect('/project/index');
            $this->view->data = $data;
        }
        $this->view->form = $form;
    }

    public function statusAction() {
        $id = $this->_getParam('id');
        $model = new Application_Model_project();
               $arr = array('status' => '0');
        $model->update($arr,'id='.$id);
        $this->_redirect('/project/index');
    }

}

?>