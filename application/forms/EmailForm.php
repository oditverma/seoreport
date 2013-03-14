<?php

class Application_Form_EmailForm extends Zend_Form {

    public function init() {
        $this->setAttrib('class', 'form-signin');
        $validator = new Zend_Validate_EmailAddress(Zend_Validate_Hostname::ALLOW_DNS |
                Zend_Validate_Hostname::ALLOW_LOCAL);
        $validator->setOptions(array('domain' => FALSE))->getHostnameValidator()
                ->setValidateIdn(false);
        $email = $this->createElement('text', 'email')->setRequired(TRUE)
                ->setAttrib('placeholder', 'Email')
                ->setLabel('E-mail : ')->addFilters(array('StringTrim', 'StripTags'))
                ->addValidator('EmailAddress', TRUE);
        $submit = $this->createElement('submit', 'submit')->setAttrib('class', 'btn btn-primary');
        $this->addElements(array($email, $submit));
    }

}
?>
