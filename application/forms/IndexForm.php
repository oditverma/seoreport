<?php

class Application_Form_IndexForm extends Zend_Form {

    public function init() {
        $name = $this->createElement('text', 'name')->setAttrib('Placeholder', 'Name')->setRequired(true)->setLabel('Name :');
        $pass = $this->createElement('password', 'pass')->setAttrib('Placeholder', 'Password')->setRequired(true)->setLabel('Password :');        
        $submit = $this->createElement('submit', 'Insert')->setAttrib('class', 'btn btn-primary')->setName('Login');
        $this->addElements(array($name, $pass, $submit));        
    }

}

?>