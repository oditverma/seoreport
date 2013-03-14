<?php

class Application_Form_CheckForm extends Zend_Form {

    public function init() {
        $account_type = $this->createElement('select', 'account_type')->addMultiOptions(array('Select Type' => 'Select Type', 'client' => 'client', 'project' => 'project'))->setAttrib('class', 'span2');
        $dateWise=$this->createElement('text', 'dateWise')->setAttrib('class', 'daterangepicker')->setAttrib('placeholder', 'Select Date');;
        $submit = $this->createElement('submit', 'submit')->setAttrib('class', 'btn btn-info');
        $this->addElements(array($account_type,$dateWise,$submit));
    }

}

?>
