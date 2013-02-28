<?php

class Application_Form_UserForm extends Zend_Form {

    public function init() {
        $form = new Zend_Form();
        $form = $this->setAttrib('class', 'form-signin');
        $name = $this->createElement('text', 'name')->setAttrib('Placeholder', 'Name')->setRequired(true)->setLabel('Name :');
        $pass = $this->createElement('password', 'pass')->setAttrib('Placeholder', 'Password')->setRequired(true)->setLabel('Password :');        
        $submit = $this->createElement('submit', 'Insert')->setAttrib('class', 'btn btn-primary')->setName('Login');
        $this->addElements(array($name, $pass, $submit));
    }

}

?>