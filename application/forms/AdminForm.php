<?php

class Application_Form_AdminForm extends Zend_Form {

    public function init() {
        $this->setAttrib('class', 'form-horizontal');
        $name = $this->createElement('text', 'name')->setAttrib('Placeholder', 'Name')->setRequired(true);
        $pass = $this->createElement('password', 'pass')->setRequired(true)->setAttrib('Placeholder', 'Password')->setRequired(true);
        $email = $this->createElement('text', 'email')->setRequired(true)->setAttrib('placeholder', 'E-mail');
        $account_type = $this->createElement('select', 'account_type')->addMultiOptions(array('Select Type'=>'Select Type','Admin' => 'Admin', 'client' => 'client', 'team' => 'team'))->setAttrib('class', 'span2');
        $address = $this->createElement('textarea', 'address')->setRequired(true)->setAttribs(array('rows' => 5, 'cols' => 5))->setAttrib('placeholder','Add Address');
        $contact = $this->createElement('text', 'contact')->setAttrib('placeholder', 'contact')->setRequired(true);
        $submit = $this->createElement('submit', 'submit')->setAttrib('class', 'btn btn-info');
        $this->addElements(array($name, $pass, $email, $account_type, $address, $contact, $submit));
    }

}

?>