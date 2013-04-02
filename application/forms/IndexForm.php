<?php

class Application_Form_IndexForm extends Zend_Form {

    public function init() {
        $name = $this->createElement('text', 'name')->setAttrib('Placeholder', 'Name')->setRequired(true)->setAttrib('class','input-block-level');
        $pass = $this->createElement('password', 'pass')->setAttrib('Placeholder', 'Password')->setRequired(true)->setAttrib('class','input-block-level');
       //$captcha=$this->createElement('','');
        $submit = $this->createElement('submit', 'submit')->setAttrib('class', 'btn btn-success btn-large')->setLabel('Login');
        $this->addElements(array($name, $pass, $submit));
    }

}

?>