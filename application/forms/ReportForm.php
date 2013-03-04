<?php

class Application_Form_ReportForm extends Zend_Form {

    public $elementDecorators = array('ViewHelper', 'Description', 'Errors', array(array('data' => 'HtmlTag'),
            array('tag' => 'td')), array('Label', array('tag' => 'td')), array(array('row' => 'HtmlTag'), array('tag' => 'tr')));
    public $buttonDecorators = array('ViewHelper', array(array('data' => 'HtmlTag'),
            array('tag' => 'td', 'class' => 'element')), array(array('Label' => 'HtmlTag'), array('tag' => 'td', 'placement' => 'prepend')), array(array('row' => 'HtmlTag'), array('tag' => 'tr')));

    public function init() {
        $this->setAttrib('class', 'form-inline');
        // $type = $this->createElement('select', 'report', array('decorators' => $this->elementDecorators))->addMultiOptions(array('Date wise' => 'Date wise', 'Year wise' => 'Year wise', 'Month wise' => 'Month wise', 'Week wise' => 'Week wise'))->setAttrib('class', 'span2');
        $from = $this->createElement('text', 'from', array('decorators' => $this->elementDecorators))->setAttrib('class', 'selectdate')->setAttrib('placeholder', 'From');
        $upto = $this->createElement('text', 'upto', array('decorators' => $this->elementDecorators))->setAttrib('class', 'selectdate')->setAttrib('placeholder', 'Upto');
        $submit = $this->createElement('submit', 'submit', array('decorators' => $this->buttonDecorators))->setAttrib('class', 'btn btn-info');
        $this->addElements(array($from, $upto, $submit));
    }

}

?>