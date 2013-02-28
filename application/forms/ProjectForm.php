<?php

class Application_Form_ProjectForm extends Zend_Form {

    public function init() {
       // $id = $this->createElement('text', 'id')->setRequired(true)->setAttrib('Placeholder', 'id')->addValidator('int');
        $title = $this->createElement('text', 'title')->setRequired(true)->setAttrib('Placeholder', 'Project Title')->addValidator('alnum');
       $status=$this->createElement('select','status')->setAttrib('class','span1')->setLabel('Current Status : ')->setRequired(TRUE)->addMultiOption('0','0')->addMultiOption('1','1');
        $submit = $this->createElement('submit', 'insert')->setRequired(true)->setAttrib('class', 'btn btn-primary');
        $this->addElements(array($title,$status,$submit));
    }

}

?>