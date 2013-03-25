<?php

class Application_Form_KeywordForm extends Zend_Form {

    public function init() {
        $row = new Application_Model_project();
        $data = $row->fetchAll();
        $keyword = $this->createElement('text', 'keyword')->setRequired(TRUE)
                        ->setAttrib('Placeholder', 'Keyword Title')->setLabel("Keyword :- ");
        $project_name = $this->createElement('select', 'project_name')
                        ->setRequired(TRUE)->setLabel("Campaign Name :- ");
        foreach ($data as $a) {
            $arr[$a->title] = $a->title;
        }
        $project_name->addMultiOption('', 'Select Project');
        $project_name->addMultiOptions($arr);
        $pos = $this->createElement('hidden', 'pos');
        $id = $this->createElement('hidden', 'project_id')->setValue($a->id);
        $submit = $this->createElement('submit', 'submit')->setAttrib('class', 'btn btn-primary')->setLabel('Add Keyword');
        $update = $this->createElement('submit', 'update')->setAttrib('class', 'btn btn-primary')->setLabel('Update Keyword');
        $this->addElements(array($keyword, $project_name, $pos, $id, $submit, $update));
    }

}

?>
