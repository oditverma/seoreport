<?php

class Application_Form_KeywordForm extends Zend_Form {

    public function init() {
        $keyword = $this->createElement('text', 'keyname')->setAttrib('required', 'required')
                ->setAttrib('Placeholder', 'Enter Keyword');
        //$project=$this->createElement('', '');
        $submit = $this->createElement('submit', 'submit')->setAttrib('class', 'btn btn-primary')->setLabel('Add New Keyword');
        $update = $this->createElement('submit', 'update')->setAttrib('class', 'btn btn-primary')->setLabel('Update');
        $this->addElements(array($keyword,$submit, $update));
    }

}

?>
