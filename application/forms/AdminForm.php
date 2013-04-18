<?php

class Application_Form_AdminForm extends Zend_Form {

    public function init() {
        $arr = array('Male' => 'Male', 'Female' => 'Female');
        $name = $this->createElement('text', 'name')->setAttrib('Placeholder', 'Name')->setRequired(true)->setLabel("Name : ");
        $gender = $this->createElement('select', 'gender')->setRequired(TRUE)->setLabel("Gender :- ")->addMultiOption('', 'I am')->addMultiOptions($arr)->setAttrib('Placeholder', 'I am ');
        $birthdate = $this->createElement('text', 'dob')->setAttrib('Placeholder', 'YYYY-MM-DD')->setAttrib('class', 'datepicker')->setAttrib('data-date-format', 'yyyy-mm-dd')->setRequired(true)->setLabel("D.O.B : ");
        $email = $this->createElement('text', 'email')->setRequired(true)->setAttrib('placeholder', '---@---')->setLabel("E-Mail : ");
        $pass = $this->createElement('password', 'password')->setRequired(TRUE)->setLabel("Password : ")->setAttrib('Placeholder', 'Password')->addValidator('StringLength', FALSE, array(4));
        $password = $this->createElement('password', 'pass')->setRequired(TRUE)->setLabel("Confirm Password : ")->setAttrib('Placeholder', 'Confirm Password')->addValidator('StringLength', false, array(4))
                ->addValidator('Identical', false, array('token' => 'password', 'messages' => 'Password do not Match !'));
        $account_type = $this->createElement('select', 'account_type')
                        ->setRequired(TRUE)->addMultiOptions(array('Select Role' => 'Select Type', 'Admin' => 'Admin', 'Client' => 'Client', 'Team' => 'Team'))->setAttrib('class', 'span2')->setLabel("Role : ");
        $address = $this->createElement('textarea', 'address')->setRequired(true)->setAttribs(array('rows' => 5, 'cols' => 5))->setAttrib('placeholder', 'Add Address')->setLabel("Address : ");
        $contact = $this->createElement('text', 'contact')->setAttrib('placeholder', '000-000-0000')->setRequired(true)->setLabel("Contact : ");
        $logo = new Zend_Form_Element_File('logo');
        $logo->setDestination(APPLICATION_PATH . '/../public/uploads')
                ->setLabel("Logo : ")
                ->setRequired(true);
        $submit = $this->createElement('submit', 'submit')->setAttrib('class', 'btn btn-info');
        $this->addElements(array($name, $gender, $birthdate, $pass, $password, $email, $account_type, $address, $contact, $logo, $submit));
    }

}

?>