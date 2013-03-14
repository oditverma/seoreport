<?php

class AdminController extends Zend_Controller_Action {
    /* Instance created for protected Function */

    protected $_adminModel = Null;
    protected $_adminForm = Null;

    public function init() {
        $auth = Zend_auth::getInstance();
        if ($auth != Zend_Auth::getInstance()->hasIdentity()) {
            Zend_Auth::getInstance()->clearIdentity();
            $this->_redirect('/user');
        }
    }

    public function indexAction() {
        $form = $this->_getAdminForm();
        $data = $this->_getAdminModel()->fetchAll('status=1');
        $this->view->data = $data;
        $this->view->form = $form;
    }

    public function editAction() {
        $form = $this->_getAdminForm();
        if ($this->_request->isPost() && $form->isValid($_POST)) {
            $data = $form->getValues();
            $value = $this->_getAdminModel()->insert(array('name' => $data['name'],
                'pass' => sha1($data['pass']),
                'email' => $data['email'],
                'account_type' => $data['account_type'],
                'address' => $data['address'],
                'contact' => $data['contact']));
            $this->_redirect('/admin/index');
            $this->view->value = $value;
        }
        $this->view->form = $form;
    }

    public function deleteAction() {
        $id = $this->_getParam('id');
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->layout->disableLayout();
        if (empty($id)) {
            throw new Exception('ID not provided');
        }
        $form = $this->_getAdminForm();
        if (!empty($id)) {
            $row = $this->_getAdminModel();
            $row->delete("id='$id'");
        }
        $this->view->form = $form;
        $this->_redirect('/admin/index');
    }

    public function updateAction() {
        $id = $this->_getParam('id');
        $form = $this->_getAdminForm();
        $model = $this->_getAdminModel();
        $result = $model->fetchrow("id='$id'");
        $form->populate($result->toArray());
        if ($this->_request->isPost() && $form->isValid($_POST)) {
            $data = $form->getValues();
            $model->update($data, "id='$id'");
            $this->_redirect('/admin/index');
        }
        $this->view->form = $form;
    }

    public function statusAction() {
        $id = $this->_getParam('id');
        $model = $this->_getAdminModel();
        $arr = array('status' => '0');
        $model->update($arr, 'id=' . $id);
        $this->_redirect('/admin/index');
    }

    public function reportAction() {
        $form = new Application_Form_CheckForm();
        /* $model = new Application_Model_report();
          $select = $model->select()->from(array('report' => 'report'), array('report.id', 'report.task', 'report.added_by', 'report.assigned_to', 'report.time_added', 'report.attachment'))
          ->join(array('project' => 'project'), 'project.id=report.project_id', array());
          $show = $model->fetchAll($select);
          $this->view->show = $show; */
        $this->view->form = $form;
    }

    /* Function created for Model and Form */

    protected function _getAdminModel() {
        if (!$this->_adminModel instanceof Application_Model_admin) {
            $this->_adminModel = new Application_Model_admin();
        }
        return $this->_adminModel;
    }

    protected function _getAdminForm() {
        if (!$this->_adminForm instanceof Application_Form_AdminForm) {
            $this->_adminForm = new Application_Form_AdminForm();
        }
        return $this->_adminForm;
    }

    /* $row = new Application_Model_admin();
      $data = $row->fetchAll();
      $this->view->data = $data;
      $this->view->form = $form;
      if ($this->_request->isPost() && $form->isValid($_POST)) {
      if (isset($_POST['add'])) {
      $data = $form->getValues();
      $row = new Application_Model_country();
      $row->insert($data);
      $this->view->data = $data;
      }
      if (isset($_POST['del'])) {
      $id = $this->_getParam('id');
      $data = $form->getValues();
      $row = new Application_Model_country();
      $row->delete('id=' . $id);
      $this->view->data = $data;
      }
      }
      $row = new Application_Model_country();
      $data = $row->fetchAll();
      $this->view->data = $data;

      public function userAction() {
      $form = new Application_Form_UserForm();
      if ($this->_request->isPost() && $form->isValid($_POST)) {
      $data = $form->getValues();
      $row = new Application_Model_state();
      $row->insert($data);
      }
      $this->view->form = $form;
      $row1 = new Application_Model_state();
      $data1 = $row1->fetchAll();
      $this->view->data1 = $data1;
      }

      public function showAction() {
      $model = new Application_Model_admin();
      $rows = $model->fetchAll();
      $this->view->rows = $rows;
      }

      public function editAction() {
      $form = new Application_Form_UserForm();
      $id = $this->_getParam('id');

      if (empty($id)) {
      throw new Exception('ID not provided');
      }

      $model = new Application_Model_admin();
      $row = $model->fetchRow('id=' . $id);

      //Zend_Debug::dump($row->toArray());

      $form->populate($row->toArray());

      if ($this->_request->isPost() && $form->isValid($_POST)) {
      $data = $form->getValues();
      $model->update($data, 'id=' . $id);
      $this->_redirect('/user/show');
      }
      $this->view->form = $form;
      }

      public function deleteAction() {
      $this->_helper->viewRenderer->setNoRender();
      $this->_helper->layout->disableLayout();

      $id = $this->_getParam('id');

      if (empty($id)) {
      throw new Exception('ID not provided');
      }


      $model = new Application_Model_admin();
      $model->delete('id=' . $id);
      $this->_redirect('/user/show');
      } */
}

?>
