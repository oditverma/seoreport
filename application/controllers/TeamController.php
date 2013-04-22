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
        $form->removeElement('pass');
        $model = new Application_Model_admin();
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
        $form = new Application_Form_TaskForm();
        $form->removeElement('attachment');
         $form->removeElement('time_completed');
        if ($this->_request->isPost() && $form->isValid($_POST)) {
            $row = new Application_Model_report();
            $data = $form->getValues();
            echo "<pre>";
            print_r($data);
            die();
            $row->insert($data);
            $this->_redirect('/team/index');
            $this->view->data = $data;
        }
        $this->view->form = $form;
    }

    public function profileAction() {
        if (!Zend_Auth::getInstance()->hasIdentity()) {
            $this->_redirect('/index');
        }
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
        if (!Zend_Auth::getInstance()->hasIdentity()) {
            $this->_redirect('/index');
        }
        $model = new Application_Model_project();
        $row = $model->fetchAll();
        $this->view->row = $row;
    }

     public function reportAction() {
         
        $model = new Application_Model_project();
        $row = $model->fetchAll();
        $this->view->row = $row;
    }
     public function logoutAction() {
        $authAdapter = Zend_Auth::getInstance();
        $authAdapter->clearIdentity();
        $this->_redirect('/index/login');
    }

    
    /*  public function keywordAction() {
      $form = new Application_Form_KeywordForm();
      $db = new Application_Model_keyword();
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
      $this->_redirect('/team/keyword');
      }
      $row = new Application_Model_keyword();
      $select = $row->fetchAll('1=1', 'pos');
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
      $this->_redirect('/team/keyword');
      }

      public function keyupdtAction() {
      $id = $this->_getParam('id');
      $model = new Application_Model_keyword();
      $form = new Application_Form_KeywordForm();
      $result = $model->fetchrow("id=" . $id);
      $form->populate($result->toArray());
      if ($this->_request->isPost() && $form->isValid($_POST)) {
      $data = $form->getValues();
      $model->update($data, "id='$id'");
      $this->_redirect('/team/keyword');
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
      $this->_redirect('team/keyword');
      }
      $currentDisplayOrder = $row->pos;
      $lesserRow = $model->fetchRow(" pos< $currentDisplayOrder ", "pos desc limit 1");
      if ($currentDisplayOrder == $lesserRow->pos) {
      $this->_redirect('team/keyword');
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
      $this->_redirect('team/keyword');
      } catch (Zend_Exception $e) {
      $error = $e->getMessage();
      echo"<script>bootbox.alert('$error');</script>";
      $this->_redirect('team/keyword');
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
      $this->_redirect('team/keyword');
      }
      $currentDisplayOrder = $row->pos;
      $lesserRow = $model->fetchRow(" pos> $currentDisplayOrder ", " pos ASC limit 1");
      if ($currentDisplayOrder == $lesserRow->pos) {
      $this->_redirect('team/keyword');
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
      $this->_redirect('team/keyword');
      } catch (Zend_Exception $e) {
      echo $e->getMessage();
      $this->_redirect('team/keyword');
      }
      } */
}

?>