<?php

class Application_Form_AdminForm extends Zend_Form {

    public $elementDecorators = array('ViewHelper', 'Description', 'Errors', array(array('data' => 'HtmlTag'),
            array('tag' => 'td')), array('Label', array('tag' => 'td')), array(array('row' => 'HtmlTag'), array('tag' => 'tr')));
    public $fileDecorators = array('File', 'Errors', array(array('data' => 'HtmlTag'), array('tag' => 'td')),
        array('Label', array('tag' => 'th')), array(array('row' => 'HtmlTag'), array('tag' => 'tr')));
    public $buttonDecorators = array('ViewHelper', array(array('data' => 'HtmlTag'), array('tag' => 'td', 'class' => 'element')),
        array(array('Label' => 'HtmlTag'), array('tag' => 'td', 'placement' => 'prepend')), array(array('row' => 'HtmlTag'), array('tag' => 'tr')));

    public function init() {
        $name = $this->createElement('text', 'name', array('decorators' => $this->elementDecorators))->setAttrib('Placeholder', 'Name')->setRequired(true)->setLabel("Name : ");
        $email = $this->createElement('text', 'email', array('decorators' => $this->elementDecorators))->setRequired(true)->setAttrib('placeholder', 'E-mail')->setLabel("E-Mail : ");
        $account_type = $this->createElement('select', 'account_type', array('decorators' => $this->elementDecorators))
                        ->addMultiOptions(array('Select Role' => 'Select Type', 'Admin' => 'Admin', 'client' => 'client', 'team' => 'team'))->setAttrib('class', 'span2')->setLabel("Role : ");
        $address = $this->createElement('textarea', 'address', array('decorators' => $this->elementDecorators))->setRequired(true)->setAttribs(array('rows' => 5, 'cols' => 5))->setAttrib('placeholder', 'Add Address')->setLabel("Address : ");
        $contact = $this->createElement('text', 'contact', array('decorators' => $this->elementDecorators))->setAttrib('placeholder', 'contact')->setRequired(true)->setLabel("Contact : ");
        $logo = new Zend_Form_Element_File('logo', array('decorators' => $this->fileDecorators));
        $logo->setDestination(APPLICATION_PATH . '/../public/uploads')
                ->setLabel("Logo : ")
                ->setRequired(true);
        $submit = $this->createElement('submit', 'submit', array('decorators' => $this->buttonDecorators))->setAttrib('class', 'btn btn-info');
        $this->addElements(array($name, $email, $account_type, $address, $contact, $logo, $submit));
        $this->setDecorators(array('FormElements', array(array('data' => 'HtmlTag'), array('tag' => 'table')), 'Form'));
    }

}

?>