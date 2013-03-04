<?php

class Application_Form_ClientForm extends Zend_Form {

    public function init() {
        $this->setAttrib('class', 'form-signin');
        $Cname = $this->createElement('text', 'Cname')->setAttrib('Placeholder', 'Username')->setLabel('Name : ')->setRequired(true);
        $pass = $this->createElement('password', 'pass')->setRequired(true)->setAttrib('Placeholder', 'Password')->addValidator('alnum')->setLabel('Password : ');
        $submit = $this->createElement('submit', 'submit')->setAttrib('class', 'btn btn-primary');
        $this->addElements(array($Cname, $pass, $submit));
    }

}

?>
