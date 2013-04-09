<?php

class Application_Form_AdminForm extends Zend_Form {

    public function init() {
        $this->setAttrib('class', 'bs-docs-example form-horizontal');
        $name = $this->createElement('text', 'name')->setAttrib('Placeholder', 'Name')->setRequired(true)->setLabel("Name :- ");
        $email = $this->createElement('text', 'email')->setRequired(true)->setAttrib('placeholder', 'E-mail')->setLabel("E-Mail :- ");
        $account_type = $this->createElement('select', 'account_type')->addMultiOptions(array('Select Role' => 'Select Type', 'Admin' => 'Admin', 'client' => 'client', 'team' => 'team'))->setAttrib('class', 'span2')->setLabel("Role :- ");
        $address = $this->createElement('textarea', 'address')->setRequired(true)->setAttribs(array('rows' => 5, 'cols' => 5))->setAttrib('placeholder', 'Add Address')->setLabel("Address :- ");
        $contact = $this->createElement('text', 'contact')->setAttrib('placeholder', 'contact')->setRequired(true)->setLabel("Contact :- ");
        $logo = new Zend_Form_Element_File('logo');
        $logo->setDestination(APPLICATION_PATH . '/../public/uploads')
                ->setLabel("Logo")
                ->setRequired(true);
        $submit = $this->createElement('submit', 'submit')->setAttrib('class', 'btn btn-info');
        $this->addElements(array($name, $email, $account_type, $address, $contact, $logo, $submit));
    }

}

?>