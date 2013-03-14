<?php

class Application_Form_TeamForm extends Zend_Form {

    public function init() {
        $this->setAttrib('class', 'form-signin');
        $name = $this->createElement('text', 'name')->setAttrib('Placeholder', 'name')->setLabel('Name :')->setRequired(TRUE);
        $pass = $this->createElement('password', 'pass')->setRequired(true)->setAttrib('Placeholder', 'pass')->addValidator('alnum')->setLabel('Password :');
        /* $captcha = $this->createElement('captcha', 'captcha', array('label' => 'Please enter the 5 letters displayed below:',
          'required' => true, 'captcha' => array('captcha' => 'dumb', 'wordLen' => 5))); */
        $submit = $this->createElement('submit', 'submit')->setAttrib('class', 'btn btn-success');
        $this->addElements(array($name, $pass, $submit));
    }

}

?>