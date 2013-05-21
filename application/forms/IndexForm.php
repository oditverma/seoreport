<?php

class Application_Form_IndexForm extends Zend_Form {

    public $elementDecorators = array('ViewHelper', 'Description', 'Errors', array(array('data' => 'HtmlTag'),
            array('tag' => 'td')), array('Label', array('tag' => 'td')), array(array('row' => 'HtmlTag'), array('tag' => 'tr')));

    public function init() {
        $name = $this->createElement('text', 'name')->setRequired(true)->setAttrib('class', 'input-block-level')->setLabel("Username");
        $pass = $this->createElement('password', 'pass')->setRequired(true)->setAttrib('class', 'input-block-level')->setLabel("Password");
        $check = $this->createElement('checkbox', 'check')->setAttrib('checked', false)->setLabel("Stay signed in");
        $submit = $this->createElement('submit', 'submit')->setAttrib('class', 'btn btn-success btn-large')->setLabel('Login');
        $this->addElements(array($name, $pass, $check, $submit));
    }

}

?>