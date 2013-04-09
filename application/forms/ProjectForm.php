<?php

class Application_Form_ProjectForm extends Zend_Form {

    public $elementDecorators = array('ViewHelper', 'Description', 'Errors', array(array('data' => 'HtmlTag'),
            array('tag' => 'td')), array('Label', array('tag' => 'td')), array(array('row' => 'HtmlTag'), array('tag' => 'tr')));
    public $fileDecorators = array('File', 'Errors', array(array('data' => 'HtmlTag'), array('tag' => 'td')),
        array('Label', array('tag' => 'th')), array(array('row' => 'HtmlTag'), array('tag' => 'tr')));
    public $buttonDecorators = array('ViewHelper', array(array('data' => 'HtmlTag'),
            array('tag' => 'td', 'class' => 'element')), array(array('Label' => 'HtmlTag'), array('tag' => 'td', 'placement' => 'prepend')), array(array('row' => 'HtmlTag'), array('tag' => 'tr')));

    public function init() {
        $model = new Application_Model_admin();
        $row = $model->fetchAll();
        $title = $this->createElement('text', 'title', array('decorators' => $this->elementDecorators))->setRequired(true)->setAttrib('Placeholder', 'Project Title')->setLabel("Project Title : ");
        $description = $this->createElement('textarea', 'description', array('decorators' => $this->elementDecorators))->setRequired(true)->setAttribs(array('rows' => 5, 'cols' => 5))->setAttrib('placeholder', 'Add Description')->setLabel('Add Description : ');
        $date_added = $this->createElement('text', 'date_added', array('decorators' => $this->elementDecorators))->setAttrib('class', 'datepicker')->setRequired(true)->setAttrib('Placeholder', 'YYYY/MM/DD')->setLabel("Date Added : ");
        $attachment = $this->createElement('file', 'attachment', array('decorators' => $this->fileDecorators))->setAttrib('Placeholder', 'Choose a file')->setLabel("Attachment : ");
        $attachment->setDestination(APPLICATION_PATH . '/../public/uploads')->setRequired(true);
        $user_id = $this->createElement('select', 'user_id', array('decorators' => $this->elementDecorators))->setRequired(TRUE)->setAttrib('class', 'span2')->setLabel("Assign to : ");
        foreach ($row as $r) {
            $arr[$r->id] = $r->name;
        }
        $user_id->addMultiOption('', 'Assign to');
        $user_id->addMultiOptions($arr);
        $submit = $this->createElement('submit', 'insert', array('decorators' => $this->buttonDecorators))->setRequired(true)->setAttrib('class', 'btn btn-primary');
        $this->addElements(array($title, $description, $date_added, $attachment, $user_id, $submit));
        $this->setDecorators(array('FormElements', array(array('data' => 'HtmlTag'), array('tag' => 'table')), 'Form'));
    }

}

?>