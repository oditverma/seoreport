<?php

class Application_Form_KeywordForm extends Zend_Form {

    public $elementDecorators = array('ViewHelper', 'Description', 'Errors', array(array('data' => 'HtmlTag'),
            array('tag' => 'td')), array('Label', array('tag' => 'td')), array(array('row' => 'HtmlTag'), array('tag' => 'tr')));
    public $buttonDecorators = array('ViewHelper', array(array('data' => 'HtmlTag'),
            array('tag' => 'td', 'class' => 'element')), array(array('Label' => 'HtmlTag'),
            array('tag' => 'td', 'placement' => 'prepend')), array(array('row' => 'HtmlTag'), array('tag' => 'tr')));

    public function init() {
        $row = new Application_Model_project();
        $data = $row->fetchAll();

        $keyword = $this->createElement('text', 'keyword', array('decorators' => $this->elementDecorators))->setRequired(TRUE)
                        ->setAttrib('Placeholder', 'Keyword Title')->setLabel("Keyword :- ");
        $project_name = $this->createElement('select', 'project_name', array('decorators' => $this->elementDecorators))
                        ->setRequired(TRUE)->setLabel("Campaign Name :- ");
        foreach ($data as $a) {
            $arr[$a->title] = $a->title;
        }
        $project_name->addMultiOption('', 'Select Project');
        $project_name->addMultiOptions($arr);
        $time_added = $this->createElement('hidden', 'time_added')->setValue(date('Y-m-d h:i:s'));
        $pos = $this->createElement('hidden', 'pos');
        $id = $this->createElement('hidden', 'project_id')->setValue($a->id);
        $submit = $this->createElement('submit', 'submit', array('decorators' => $this->buttonDecorators))->setAttrib('class', 'btn btn-primary')->setLabel('Add Keyword');
        $this->addElements(array($keyword, $project_name, $time_added,$pos,$id, $submit));
        $this->setDecorators(array('FormElements', array(array('data' => 'HtmlTag'), array('tag' => 'table')), 'Form'));
    }

}

?>
