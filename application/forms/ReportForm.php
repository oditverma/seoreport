<?php

class Application_Form_ReportForm extends Zend_Form {

    public function init() {
        $pickDate = $this->createElement('text', 'pickDate')->setAttrib('class', 'daterangepicker')->setAttrib('placeholder', 'Select Date')->setLabel("Select Date :- ")->setRequired(TRUE);
        $submit = $this->createElement('submit', 'submit')->setAttrib('class', 'btn btn-info');
        $this->addElements(array($pickDate, $submit));
    }

}

?>