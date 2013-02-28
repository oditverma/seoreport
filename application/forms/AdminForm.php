<?php

class Application_Form_AdminForm extends Zend_Form {

    public function init() {

        //$id = $this->createElement('text', 'id')->setRequired(true)->setAttrib('Placeholder', 'id')->addValidator('int');
        $name = $this->createElement('text', 'name')->setAttrib('Placeholder', 'name')->setLabel('Name :');
        $pass = $this->createElement('password', 'pass')->setRequired(true)->setAttrib('Placeholder', 'pass')->addValidator('alnum')->setLabel('Password :');
        $submit = $this->createElement('submit', 'submit')->setAttrib('class', 'btn btn-success');
        //->addDecorator('HtmlTag', array('tag' => 'i', 'class' => 'icon-plus-sign'))
        $this->addElements(array($name, $pass,$submit));
    }

}

?>