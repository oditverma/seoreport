<?php

class Application_Form_KeywordForm extends Zend_Form {

    public function init() {
        $row = new Application_Model_project();
        $data = $row->fetchAll();
        $keyword = $this->createElement('text', 'keyname')->setRequired(TRUE)
                        ->setAttrib('Placeholder', 'Keyword Title')->setLabel("Keyword :- ");
        $project_id = $this->createElement('select', 'project_id')
                        ->setRequired(TRUE)->setLabel("Campaign Name :- ");
        foreach ($data as $value) {
            $arr[$value->id] = $value->id;
        }
        $project_id->addMultiOption(' ', 'Select Project');
        $project_id->addMultiOptions($arr);
        $submit = $this->createElement('submit', 'submit')->setAttrib('class', 'btn btn-primary')->setLabel('Add Keyword');
        $update = $this->createElement('submit', 'update')->setAttrib('class', 'btn btn-primary')->setLabel('Update Keyword');
        $this->addElements(array($keyword, $project_id,$submit, $update));
    }

}

?>
