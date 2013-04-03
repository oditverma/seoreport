<?php

class Application_Form_AdminForm extends Zend_Form {

    public function init() {
        $this->setAttrib('class', 'form-signin');
        $name = $this->createElement('text', 'name')->setAttrib('Placeholder', 'Name')->setRequired(true);
        $email = $this->createElement('text', 'email')->setRequired(true)->setAttrib('placeholder', 'E-mail');
        $account_type = $this->createElement('select', 'account_type')->addMultiOptions(array('Select Type' => 'Select Type', 'Admin' => 'Admin', 'client' => 'client', 'team' => 'team'))->setAttrib('class', 'span2');
        $address = $this->createElement('textarea', 'address')->setRequired(true)->setAttribs(array('rows' => 5, 'cols' => 5))->setAttrib('placeholder', 'Add Address');
        $contact = $this->createElement('text', 'contact')->setAttrib('placeholder', 'contact')->setRequired(true);
        $logo = new Zend_Form_Element_File('logo');
        $logo->setDestination(APPLICATION_PATH . '/../public/uploads')
                ->setRequired(true);
        $submit = $this->createElement('submit', 'submit')->setAttrib('class', 'btn btn-info');
        $this->addElements(array($name, $email, $account_type, $address, $contact, $logo, $submit));
    }

}

?>