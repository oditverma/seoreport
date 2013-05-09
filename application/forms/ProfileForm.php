<?php

class Application_Form_ProfileForm extends Zend_Form {

    public function init() {
        $email = $this->createElement('text', 'email')->setLabel('Email :')->setRequired(TRUE)->setAttrib('placeholder', 'Email')->setAttrib('readonly', 'true')->setAttrib('required', 'required');
        $name = $this->createElement('text', 'name')->setLabel('Name :')->setRequired(TRUE)->setAttrib('placeholder', 'Name');
        $address = $this->createElement('textarea', 'address')->setRequired(TRUE)->setAttrib('rows', '5')->setAttrib('cols', '5')->setLabel('Address')->setAttrib('placeholder', 'Edit Address');
        $logo = new Zend_Form_Element_File('logo');
        $logo->setDestination(APPLICATION_PATH . '/../public/uploads')
                ->setLabel("Logo : ")
                ->setRequired(true);
        $submit = $this->createElement('submit', 'submit')->setAttrib('class', 'btn btn-info');
        $this->addElements(array($email, $name, $address, $logo,$submit));
    }

}

?>
