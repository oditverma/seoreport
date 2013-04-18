<?php

class AdminController extends Zend_Controller_Action {

    protected $_adminModel = Null;
    protected $_adminForm = Null;

    public function init() {
        $auth = Zend_Auth::getInstance();
        $type = $auth->getIdentity()->account_type;
        if (!$auth->hasIdentity()) {
            Zend_Auth::getInstance()->clearIdentity();
            $this->_redirect('/index');
        } else if ($type == 'Team' || $type == 'Client') {
            Zend_Auth::getInstance()->clearIdentity();
            $this->_redirect('/index');
        }
    }

    public function indexAction() {
        
    }

    public function editAction() {
        $form = $this->_getAdminForm();
        if ($this->_request->isPost() && $form->isValid($_POST)) {
            $data = $form->getValues();
            $data['status'] = 1;
            /*echo "<pre>";
            print_r($data);
            die();*/
            $value = $this->_getAdminModel()->insert(array('name' => $data['name'],
                'gender' => $data['gender'],
                'dob' => $data['dob'],
                'pass' => $data['pass'],
                'email' => $data['email'],
                'account_type' => $data['account_type'],
                'address' => $data['address'],
                'contact' => $data['contact'],
                'logo' => $data['logo']));

            $this->_redirect('/admin/index');
            $this->view->value = $value;
        }
        $this->view->form = $form;
    }

    public function deleteAction() {
        $id = $this->_getParam('id');
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->layout->disableLayout();
        $form = $this->_getAdminForm();
        $row = $this->_getAdminModel();
        if (!empty($id)) {
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
        $status = $model->fetchRow("id='$id' ");
        if ($status['status'] == 1) {
            $arr = array('status' => '0');
        } if ($status['status'] == 0) {
            $arr = array('status' => '1');
        }
        $model->update($arr, 'id=' . $id);
        $this->_redirect('/admin/index');
    }

    public function forgotAction() {
        $form = new Application_Form_ForgotForm();
        $model = new Application_Model_admin();
        $auth = Zend_Auth::getInstance();
        $id = $auth->getIdentity()->id;
        if ($this->_request->isPost() && $form->isValid($_POST)) {
            $pass = $form->getValues();
            $model->update(array('pass' => $pass['pass']), "id='$id'");
            $this->_redirect('/admin/index');
        }
        $this->view->form = $form;
    }

    public function reportAction() {
        if (!Zend_Auth::getInstance()->hasIdentity()) {
            Zend_Auth::getInstance()->clearIdentity();
            $this->_redirect('/index');
        }
        $form = new Application_Form_ReportForm();
        $auth = Zend_Auth::getInstance();
        $id = $auth->getIdentity()->id;
        if ($this->_request->isPost() && $form->isValid($_POST)) {
            $data = $form->getValue('pickDate');
            $db = Zend_Db_Table::getDefaultAdapter();
            $date = explode(' - ', $data);
            if (!empty($date[1])) {
                $select = $db->select()
                        ->from(array('report' => 'report'), array('report.title', 'report.description', 'report.attachment'))
                        ->join(array('project' => 'project'), 'project.id=report.project_id', array())
                        ->where("project.user_id='$id' and report.time_added='$date[0]'")
                        ->orWhere("report.time_added between '$date[0]' and '$date[1]'");
            }
            /* echo $select;
              die(); */
            $show = $db->fetchAll($select);
            $this->view->show = $show;
        }
        $this->view->form = $form;
    }

    public function viewAction() {
        $form = $this->_getAdminForm();
        $data = $this->_getAdminModel()->fetchAll();
        $this->view->data = $data;
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
