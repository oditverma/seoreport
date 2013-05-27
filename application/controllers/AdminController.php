<?php

class AdminController extends Zend_Controller_Action {

    protected $_adminModel = Null;
    protected $_adminForm = Null;

    public function init() {
        $type = Zend_Auth::getInstance()->getIdentity()->account_type;
        if (!Zend_Auth::getInstance()->hasIdentity()) {
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
            $value = $this->_getAdminModel()->insert(array('name' => $data['name'],
                'gender' => $data['gender'],
                'dob' => $data['dob'],
                'pass' => $data['pass'],
                'email' => $data['email'],
                'account_type' => $data['account_type'],
                'address' => $data['address'],
                'contact' => $data['contact'],
                'logo' => $data['logo']));
            $smtpOptions = array('auth' => 'login',
                'username' => 'oditverma@gmail.com',
                'password' => 'Odit4841@',
                'ssl' => 'ssl',
                'port' => 465);
            $tr = new Zend_Mail_Transport_Smtp('smtp.gmail.com', $smtpOptions);
            Zend_Mail::setDefaultTransport($tr);
            $mail = new Zend_Mail();
            $mail->setBodyText("You Account has been created and you user name is :  " . $data['name'] . '  and your password is : ' . $data['pass']);
            $mail->setFrom('oditverma@gmail.com', 'Odit');
            $mail->addTo($data ['email'], 'fwd');
            $mail->addCc('oditverma@gmail.com', 'fwd');
            $mail->setSubject('Testing Subject');
            echo "<script>bootbox.alert('Email Message has been sent on your Mail');</script>";
            $mail->send($tr);
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
        $this->_redirect('/admin/view');
    }

    public function forgotAction() {
        $form = new Application_Form_ForgotForm();
        $model = new Application_Model_admin();
        $id = Zend_Auth::getInstance()->getIdentity()->id;
        if ($this->_request->isPost() && $form->isValid($_POST)) {
            $pass = $form->getValues();
            $model->update(array('pass' => $pass['pass']), "id='$id'");
            $this->_redirect('/admin/index');
        }
        $this->view->form = $form;
    }

    public function reportAction() {
        $form = new Application_Form_ReportForm();
        if ($this->_request->isPost() && $form->isValid($_POST)) {
            $data = $form->getValue('pickDate');
            $p_id = $form->getValue('title');
            $c_id = $form->getValue('account_type');
            $db = Zend_Db_Table::getDefaultAdapter();
            $date = explode(' - ', $data);
            if (!empty($date[1])) {
                $select = $db->select()
                        ->from(array('report' => 'report'), array('report.title', 'report.description', 'report.attachment'))
                        ->join(array('project' => 'project'), 'project.id=report.project_id', array())
                        ->where("report.time_added between '$date[0]' and '$date[1]'");
            }
            if (!empty($p_id)) {
                $select = $db->select()
                        ->from(array('report' => 'report'), array('report.title', 'report.description', 'report.attachment'))
                        ->join(array('project' => 'project'), 'project.id=report.project_id', array())
                        ->where("report.project_id='$p_id'");
            }
            if (!empty($c_id)) {
                $select = $db->select()
                        ->from(array('report' => 'report'), array('report.title', 'report.description', 'report.attachment'))
                        ->join(array('project' => 'project'), 'project.id=report.project_id', array())
                        ->join(array('user' => 'user'), 'user.id=project.user_id', array())
                        ->where("user.id = '$c_id'");
            }
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

    public function logoutAction() {
        $authAdapter = Zend_Auth::getInstance();
        $authAdapter->clearIdentity();
        $this->_redirect('/index/login');
    }

}

?>
