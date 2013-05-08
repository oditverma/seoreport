<?php

class Application_Form_ProjectForm extends Zend_Form {

    public function init() {
        $model = new Application_Model_admin();
        $row = $model->fetchAll();
        $title = $this->createElement('text', 'title')->setRequired(true)->setAttrib('Placeholder', 'Project Title')->setLabel("Project Title : ");
        $description = $this->createElement('textarea', 'description')->setRequired(true)->setAttribs(array('rows' => 5, 'cols' => 5))->setAttrib('placeholder', 'Add Description')->setLabel('Add Description : ');
        $date_added = $this->createElement('text', 'date_added')->setAttrib('class', 'datepicker')->setRequired(true)->setAttrib('Placeholder', 'YYYY/MM/DD')->setLabel("Date Added : ");
        $attachment = $this->createElement('file', 'attachment')->setAttrib('Placeholder', 'Choose a file')->setLabel("Attachment : ");
        $attachment->setDestination(APPLICATION_PATH . '/../public/uploads')->setRequired(true);
        $user_id = $this->createElement('select', 'user_id')->setRequired(TRUE)->setLabel("Assign to : ");
        foreach ($row as $r) {
            $arr[$r->id] = $r->name;
        }
        $user_id->addMultiOption('', 'Assign to');
        $user_id->addMultiOptions($arr);
        $submit = $this->createElement('submit', 'insert')->setRequired(true)->setAttrib('class', 'btn btn-primary');
        $this->addElements(array($title, $description, $date_added, $attachment, $user_id, $submit));
    }

}

?>