<?php

class TeamController extends Zend_Controller_Action {

    public function init() {
        if (!Zend_Auth::getInstance()->hasIdentity()) {
            $this->_redirect('/index');
        }
    }

    public function indexAction() {
        if (!Zend_Auth::getInstance()->hasIdentity()) {
            $this->_redirect('/index');
        }
    }

    public function teamAction() {
        if (!Zend_Auth::getInstance()->hasIdentity()) {
            $this->_redirect('/index');
        }
        $auth = Zend_Auth::getInstance();
        $id = $auth->getIdentity()->id;
        $db = Zend_Db_Table::getDefaultAdapter();
        $select = $db->select()->from(array('report' => 'report'), array('report.id', 'report.task', 'report.added_by', 'report.assigned_to', 'report.time_added', 'report.attachment'))
                ->join(array('project' => 'project'), 'project.id=report.project_id', array())
                ->where("project.user_id='$id'");
        /*  echo $select;
          die(); */
        $show = $db->fetchAll($select);
        $this->view->show = $show;
    }

    public function forgotAction() {
        if (!Zend_Auth::getInstance()->hasIdentity()) {
            $this->_redirect('/index');
        }
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

    public function recoverAction() {
        $form = new Application_Form_EmailForm();
        $model = new Application_Model_admin();
        $hash = substr(sha1(microtime()), 0, 6);
        $arr['pass'] = $hash;
        if ($this->_request->isPost() && $form->isValid($_POST)) {
            $data = $form->getValues();
            $id = $data['email'];
            $model->update($arr, "email='$id'");
            $smtpOptions = array('auth' => 'login',
                'username' => 'oditverma@gmail.com',
                'password' => 'Eddy@169318',
                'ssl' => 'ssl',
                'port' => 465);
            $tr = new Zend_Mail_Transport_Smtp('smtp.gmail.com', $smtpOptions);
            Zend_Mail::setDefaultTransport($tr);
            $mail = new Zend_Mail();
            $mail->setBodyText('Your Password has successfully changed.' . ' Your new Account password is ' . "$hash");
            $mail->setFrom('oditverma@gmail.com', 'Odit');
            $mail->addTo($id, 'fwd');
            $mail->addCc('oditverma@gmail.com', 'fwd');
            $mail->setSubject('TestSubject');
            $mail->send($tr);
            $this->_redirect('/team/forgot');
        }
        $this->view->form = $form;
    }

    public function updtAction() {
        $id = $this->_getParam('id');
        $form = new Application_Form_UpdtForm();
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
        if (!Zend_Auth::getInstance()->hasIdentity()) {
            $this->_redirect('/team');
        }
        $form = new Application_Form_TaskForm();
        $form->removeElement('id');
        if ($this->_request->isPost() && $form->isValid($_POST)) {
            $row = new Application_Model_report();
            $data = $form->getValues();
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
            $this->_redirect('/team');
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
        $model = new Application_Model_project();
        $row = $model->fetchAll();
        $this->view->row = $row;
    }

    public function keywordAction() {
        $form = new Application_Form_KeywordForm();
        if ($this->_request->isPost() && $form->isValid($_POST)) {
            $row = new Application_Model_keyword();
            $data = $form->getValues();
            $row->insert($data);
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
        $form->clearElements(array('pos' => 'pos', 'time_added' => 'time_added', 'id' => 'id'));
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
    }

}

?>