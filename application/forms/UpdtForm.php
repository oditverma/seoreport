<?php

class Application_Form_UpdtForm extends Zend_Form {

    public function init() {
        $form = new Zend_form();
        $form = $this->setAttrib('class', 'form-horizontal');
        $id = $this->createElement('text', 'id')->setRequired(TRUE)->setLabel('Id : ')->addValidator('int');
        $name = $this->createElement('text', 'name')->setAttrib('Placeholder', 'name')->setLabel('Name :')->setRequired(TRUE);
        $pass = $this->createElement('password', 'pass')->setRequired(true)->setAttrib('Placeholder', 'pass')->addValidator('alnum')->setLabel('Password :');
        $email = $this->createElement('text', 'email')->setAttrib('Placeholder', 'name')->setLabel('Email :')->setRequired(TRUE);
          $file = new Zend_Form_Element_File('file');
        $file->setDestination(APPLICATION_PATH . '/../public/uploads')
                ->setRequired(true);
        $submit = $this->createElement('submit', 'submit')->setAttrib('class', 'btn btn-error');
        $this->addElements(array($id, $name, $pass, $email,$file,$submit));
    }

}

?>
