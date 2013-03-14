<?php

class Application_Form_ProfileForm extends Zend_Form {

    public $elementDecorators = array('ViewHelper', 'Description', 'Errors', array(array('data' => 'HtmlTag'),
            array('tag' => 'td')), array('Label', array('tag' => 'td')), array(array('row' => 'HtmlTag'), array('tag' => 'tr')));
    public $buttonDecorators = array('ViewHelper', array(array('data' => 'HtmlTag'),
            array('tag' => 'td', 'class' => 'element')), array(array('Label' => 'HtmlTag'), array('tag' => 'td', 'placement' => 'prepend')), array(array('row' => 'HtmlTag'), array('tag' => 'tr')));

    public function init() {
        $this->setAttrib('class', 'form-signin');
        $id = $this->createElement('text', 'id', array('decorators' => $this->elementDecorators))->setRequired(TRUE)->setLabel('Id : ')->addValidator('int')->setAttrib('placeholder', 'ID')->setAttrib('readonly','true');
        $name = $this->createElement('text', 'name', array('decorators' => $this->elementDecorators))->setLabel('Name :')->setRequired(TRUE)->setAttrib('placeholder', 'Name');
        $email = $this->createElement('text', 'email', array('decorators' => $this->elementDecorators))->setLabel('Email :')->setRequired(TRUE)->setAttrib('placeholder', 'Email');
        $address = $this->createElement('textarea', 'address', array('decorators' => $this->elementDecorators))->setRequired(TRUE)->setAttrib('rows', '5')->setAttrib('cols', '5')->setLabel('Address')->setAttrib('placeholder', 'Edit Address');
        $submit = $this->createElement('submit', 'submit', array('decorators' => $this->buttonDecorators))->setAttrib('class', 'btn btn-info');
        $this->addElements(array($id, $name, $email, $address, $submit));
        $this->setDecorators(array('FormElements', array(array('data' => 'HtmlTag'), array('tag' => 'table')), 'Form'));
    }

}

?>
