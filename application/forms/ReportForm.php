<?php

class Application_Form_ReportForm extends Zend_Form {

    public $elementDecorators = array('ViewHelper', 'Description', 'Errors', array(array('data' => 'HtmlTag'),
            array('tag' => 'td')), array('Label', array('tag' => 'td')), array(array('row' => 'HtmlTag'), array('tag' => 'tr')));
    public $buttonDecorators = array('ViewHelper', array(array('data' => 'HtmlTag'),
            array('tag' => 'td', 'class' => 'element')), array(array('Label' => 'HtmlTag'), array('tag' => 'td', 'placement' => 'prepend')), array(array('row' => 'HtmlTag'), array('tag' => 'tr')));

    public function init() {
        $pickDate = $this->createElement('text', 'pickDate', array('decorators' => $this->elementDecorators))->setAttrib('class', 'daterangepicker')->setAttrib('placeholder', 'Select Date');
        $submit = $this->createElement('submit', 'submit', array('decorators' => $this->buttonDecorators))->setAttrib('class', 'btn btn-info');
        $this->addElements(array($pickDate, $submit));
        $this->setDecorators(array('FormElements', array(array('data' => 'HtmlTag'), array('tag' => 'table')), 'Form'));
    }

}

?>