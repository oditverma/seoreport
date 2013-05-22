<?php

class ProjectController extends Zend_Controller_Action {

    protected $_projectForm = Null;
    protected $_projectModel = Null;

    protected function _getProjectModel() {
        if (!$this->_projectModel instanceof Application_Model_project) {
            $this->_projectModel = new Application_Model_project();
        }
        return $this->_projectModel;
    }

    protected function _getProjectForm() {
        if (!$this->_projectForm instanceof Application_Form_ProjectForm) {
            $this->_projectForm = new Application_Form_ProjectForm();
        }
        return $this->_projectForm;
    }

    public function init() {
        if (!Zend_Auth::getInstance()->hasIdentity()) {
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
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->layout->disableLayout();
        $form = $this->_getProjectForm();
        $row = $this->_getProjectModel();
        if (!empty($id)) {
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
                'description' => $data['description'],
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
        $project_id = $this->_getParam('id');
        $form = new Application_Form_KeywordForm();
        $db = new Application_Model_keyword();
        $form->removeElement('update');
        if ($this->_request->isPost() && $form->isValid($_POST)) {
            $data = $form->getValues('keyname');
            $data1 = implode($data);
            if (!empty($data)) {

                function multiexplode($delimiters, $string) {
                    $ready = str_replace($delimiters, $delimiters[0], $string);
                    $launch = explode($delimiters[0], $ready);
                    return $launch;
                }

                $key = multiexplode(array(",", ".", "|", ":", ";"), $data1);
            }

            $inc = $db->select()->from($db, array(new Zend_Db_Expr("max(pos)+1 as pos")))->where("project_id='$project_id'");
            $rs = $db->fetchRow($inc);
            $array = $rs->toArray();
            if ($array['pos'] == 0 && count($key) == 1) {
                $data['project_id'] = $project_id;
                $db->insert($data);
            } else if (count($key) > 1 && $array['pos'] == 0) {
                $array['pos'] = 0;
                foreach ($key as $val) {
                    $key1['keyname'] = $val;
                    $key1['pos'] = $array['pos']++;
                    $key1['project_id'] = $project_id;
                    $db->insert($key1);
                }
            } else if ($array['pos'] > 0) {
                foreach ($key as $val) {
                    $key1['keyname'] = $val;
                    $key1['pos'] = $array['pos']++;
                    $key1['project_id'] = $project_id;
                    $db->insert($key1);
                }
            }
            $pos = $db->fetchRow(null, 'id desc');
            $arr = $pos->toArray();
            $id = $arr['id'];
            $db->update($array, "id='$id'");
            $this->_redirect('/project/keyword/id/' . $project_id);
        }
        $row = new Application_Model_keyword();
        $select = $row->fetchAll("project_id='$project_id' ", 'pos asc');
        $model = $this->_getProjectModel();
        $data = $model->fetchAll("id='$project_id'");
        $this->view->data = $data;
        $this->view->select = $select;
        $this->view->form = $form;
    }

    public function keydelAction() {
        $id = $this->_getParam('id');
        $form = new Application_Form_KeywordForm();
        if (!empty($id)) {
            $row = new Application_Model_keyword();
            $project_id = $row->fetchRow("id='$id'");
            $p_id = $project_id->toArray();
            $row->delete("id='$id'");
        }
        $this->view->form = $form;
        $this->_redirect('/project/keyword/id/' . $p_id['project_id']);
    }

    public function keyupdtAction() {
        $id = $this->_getParam('id');
        $form = new Application_Form_KeywordForm();
        $model = new Application_Model_keyword();
        $project_id = $model->fetchRow("id='$id'");
        $p_id = $project_id->toArray();
        $result = $model->fetchrow("id='$id'");
        $form->removeElement('submit');
        $form->populate($result->toArray());
        if ($this->_request->isPost() && $form->isValid($_POST)) {
            $data = $form->getValues();
            $model->update($data, "id='$id'");
            $this->_redirect('/project/keyword/id/' . $p_id['project_id']);
        }
        $this->view->form = $form;
    }

    public function keyupAction() {
        $id = $this->getParam('id');
        $projectID = $this->_getParam('projectId');
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->layout->disableLayout();
        $model = new Application_Model_keyword();
        $row = $model->fetchRow("id='$id'");
        if (empty($id) || !$row) {
            throw new Zend_Exception('Id not provided!');
            $this->_redirect('project/keyword/id/' . $projectID);
        }
        $row->toArray();
        $currentLine = $row->pos;
        $lastRow = $model->fetchRow("pos <" . $currentLine . " and project_id='$projectID'", " pos DESC limit 1");
        $lastRow->toArray();
        if ($currentLine == $lastRow) {
            throw new Zend_Exception('Wrong swap!');
            $this->_redirect('project/keyword/id/' . $projectID);
        }
        if (!$lastRow) {
            $newOrder = ($currentLine - 1 > 1) ? $currentLine - 1 : $currentLine;
        } else {
            $newOrder = $lastRow['pos'];
            $lastRow['pos'] = $currentLine;
            $lastRow->save();
        }
        $row->pos = $newOrder;
        $row->save();
        $this->_redirect('project/keyword/id/' . $projectID);
    }

    public function keydownAction() {
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->layout->disableLayout();
        $id = $this->getParam('id');
        $projectID = $this->_getParam('projectId');
        $model = new Application_Model_keyword();
        $row = $model->fetchRow("id='$id'");
        if (empty($id) || !$row) {
            throw new Zend_Exception('Id not provided!');
            $this->_redirect('project/keyword/id/' . $projectID);
        }
        $row->toArray();
        $currentLine = $row->pos;
        $lastRow = $model->fetchRow("pos >" . $currentLine . " and project_id='$projectID'", " pos ASC limit 1");
        $lastRow->toArray();
        if ($currentLine == $lastRow) {
            throw new Zend_Exception('Wrong swap!');
            $this->_redirect('project/keyword/id/' . $projectID);
        }
        if (!$lastRow) {
            $newOrder = $currentLine + 1;
        } else {
            $newOrder = $lastRow['pos'];
            $lastRow['pos'] = $currentLine;
            $lastRow->save();
        }
        $row->pos = $newOrder;
        $row->save();
        $this->_redirect('project/keyword/id/' . $projectID);
    }

}

/* echo "<pre>";
  print_r($data);
  die(); */
?>