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
        $data = $row->fetchAll();
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
            print_r($data);
            die();
            $start = date('Y-m-d', strtotime($data['date_added']));
            $this->_getProjectModel()->insert(array('title' => $data['title'],
                'description' => $data,
                'date_added' => $start,
                'attachment' => $data['attachment'],
                'user_id' => $data['user_id']));
            $this->_redirect('/admin/index');
            $this->view->row = $row;
        }
        $this->view->form = $form;
    }

    public function statusAction() {
        $id = $this->_getParam('id');
        $model = $this->_getProjectModel();
        $status = $model->fetchRow("id='$id' ");
        if ($status['status'] == 1) {
            $arr = array('status' => '0');
        } if ($status['status'] == 0) {
            $arr = array('status' => '1');
        }
        $model->update($arr, 'id=' . $id);
        $this->_redirect('/project/index');
    }

    public function keywordAction() {
        $db = new Application_Model_keyword();
        $form = new Application_Form_KeywordForm();
        $form->removeElement("update");
        if ($this->_request->isPost() && $form->isValid($_POST)) {
            $data = $form->getValues();
            $inc = $db->select()->from($db, array(new Zend_Db_Expr('max(pos)+1 as pos')));
            $rs = $db->fetchRow($inc);
            $array = $rs->toArray();
            $db->insert($data);
            $pos = $db->fetchRow(null, 'id desc');
            $arr = $pos->toArray();
            $id = $arr['id'];
            $db->update($array, "id='$id'");
            $this->_redirect('/project/keyword');
        }
        $select = $db->fetchAll('1=1', 'pos');
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
        $form = new Application_Form_KeywordForm();
        $model = new Application_Model_keyword();
        $result = $model->fetchrow("id='$id'");
        $form->populate($result->toArray());
        if ($this->_request->isPost() && $form->isValid($_POST)) {
            $data = $form->getValues();
            $select = $model->update($data, "id='$id'");
            print_r($select);
            die();
            $this->_redirect('/project/index');
        }
        $this->view->form = $form;
    }

    public function keyupAction() {
        $this->_helper->viewRenderer->setNoRender();
        $id = $this->_request->getParam('id');
        $model = new Application_Model_keyword();
        if (empty($id)) {
            throw new Zend_Exception('Id not provided!');
        }
        $row = $model->fetchRow("id='$id'");
        if (!$row) {
            echo "<script>bootbox.alert( 'Requested page not found!');</script>";
            $this->_redirect('project/keyword');
        }
        $currentDisplayOrder = $row->pos;
        $lesserRow = $model->fetchRow(" pos< $currentDisplayOrder ", "pos desc limit 1");
        if ($currentDisplayOrder == $lesserRow->pos) {
            echo "<script>bootbox.alert( 'Requested page not found!');</script>";
            $this->_redirect('project/keyword');
        }
        if (!$lesserRow) {
            $newDisplayOrder = ($currentDisplayOrder - 1 > 1) ? $currentDisplayOrder - 1 : $currentDisplayOrder;
        } else {
            $newDisplayOrder = $lesserRow->pos;
            $lesserRow->pos = $currentDisplayOrder;
            $lesserRow->save();
        }
        try {
            $row->pos = $newDisplayOrder;
            $row->save();
            echo "<script>bootbox.alert( 'Order changed!');</script>";
            $this->_redirect('project/keyword');
        } catch (Zend_Exception $e) {
            $error = $e->getMessage();
            echo"<script>bootbox.alert('$error');</script>";
            $this->_redirect('project/keyword');
        }
    }

    public function keydownAction() {
        $this->_helper->viewRenderer->setNoRender();
        $id = $this->_request->getParam('id');
        $model = new Application_Model_keyword();
        if (empty($id)) {
            throw new Zend_Exception('Id not provided!');
        }
        $row = $model->fetchRow("id='$id'");
        if (!$row) {
            $this->_redirect('project/keyword');
        }
        $currentDisplayOrder = $row->pos;
        $lesserRow = $model->fetchRow(" pos> $currentDisplayOrder ", " pos ASC limit 1");
        if ($currentDisplayOrder == $lesserRow->pos) {
            $this->_redirect('project/keyword');
        }
        if (!$lesserRow) {
            $newDisplayOrder = $currentDisplayOrder + 1;
        } else {
            $newDisplayOrder = $lesserRow->pos;
            $lesserRow->pos = $currentDisplayOrder;
            $lesserRow->save();
        }
        try {
            $row->pos = $newDisplayOrder;
            $row->save();
            $this->_redirect('project/keyword');
        } catch (Zend_Exception $e) {
            echo $e->getMessage();
            $this->_redirect('project/kecyword');
        }
    }

    public function resourceAction() {
        
    }

}

?>