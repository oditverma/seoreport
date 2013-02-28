<?php

class AdminController extends Zend_Controller_Action {

    public function init() {
        $auth = Zend_auth::getInstance();
        if ($auth != Zend_Auth::getInstance()->hasIdentity()) {
            Zend_Auth::getInstance()->clearIdentity();
            $this->_redirect('/user');
        }
    }

    public function indexAction() {
        $form = new Application_Form_AdminForm();
        $row = new Application_Model_admin();
        $data = $row->fetchAll('status=1');
        $this->view->data = $data;
        $this->view->form = $form;
    }

    public function editAction() {
        $form = new Application_Form_AdminForm();
        if ($this->_request->isPost() && $form->isValid($_POST)) {
            $row = new Application_Model_admin();
            $data = $form->getValues();
            $row->insert($data);
            $this->_redirect('/admin/index');
            $this->view->data = $data;
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
        $form = new Application_Form_AdminForm();
        if (!empty($id)) {
            $row = new Application_Model_admin();
            $row->delete("id='$id'");
        }
        $this->view->form = $form;
        $this->_redirect('/admin/index');
    }

    public function updateAction() {
        $id = $this->_getParam('id');
        $form = new Application_Form_AdminForm();
        $model = new Application_Model_admin();
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
        $model = new Application_Model_admin();
               $arr = array('status' => '0');
        $model->update($arr,'id='.$id);
        $this->_redirect('/admin/index');
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
