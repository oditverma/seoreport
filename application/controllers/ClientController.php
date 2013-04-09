<?php

class ClientController extends Zend_Controller_Action {

    public function init() {
        $auth = Zend_Auth::getInstance();
        $type = $auth->getIdentity()->account_type;
        if (!$auth->hasIdentity()) {
            Zend_Auth::getInstance()->clearIdentity();
            $this->_redirect('/index');
        } else if ($type == 'admin' || $type == 'team') {
            Zend_Auth::getInstance()->clearIdentity();
            $this->_redirect('/index');
        }
    }

    public function indexAction() {
        if (!Zend_Auth::getInstance()->hasIdentity()) {
            Zend_Auth::getInstance()->clearIdentity();
            $this->_redirect('/index');
        }
    }

    public function projectAction() {
        if (!Zend_Auth::getInstance()->hasIdentity()) {

            $this->_redirect('/index');
        }
        $auth = Zend_Auth::getInstance();
        $id = $auth->getIdentity()->id;
        $db = Zend_Db_Table::getDefaultAdapter();
        $select = $db->select()->from(array('project' => 'project'), array('project.*'))
                ->where("user_id='$id'");
        $show = $db->fetchAll($select);
        $this->view->show = $show;
    }

    public function taskAction() {
        if (!Zend_Auth::getInstance()->hasIdentity()) {
            Zend_Auth::getInstance()->clearIdentity();
            $this->_redirect('/index');
        }
        $auth = Zend_Auth::getInstance();
        $id = $auth->getIdentity()->id;
        $db = Zend_Db_Table::getDefaultAdapter();
        $select = $db->select()->from(array('report' => 'report'), array('report.id', 'report.title', 'report.added_by', 'report.assigned_to', 'report.time_added', 'report.attachment'))
                ->join(array('project' => 'project'), 'project.id=report.project_id', array())
                ->where("project.user_id='$id'");
        /*  echo $select;
          die(); */
        $show = $db->fetchAll($select);
        $this->view->show = $show;
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
            } else {
                $select = $db->select()
                        ->from(array('report' => 'report'), array('report.title', 'report.description', 'report.attachment'))
                        ->join(array('project' => 'project'), 'project.id=report.project_id', array())
                        ->where("project.user_id='$id' and report.time_added='$date[0]'");
            }
            /* echo $select;
              die(); */
            $show = $db->fetchAll($select);
            $this->view->show = $show;
        }
        $this->view->form = $form;
    }

    public function logoutAction() {
        $authAdapter = Zend_Auth::getInstance();
        $authAdapter->clearIdentity();
        $this->_redirect('/index');
    }

}

?>