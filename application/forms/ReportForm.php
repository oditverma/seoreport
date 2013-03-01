<?php

class Application_Form_ReportForm extends Zend_Form {

    public function init() {
        $from = $this->createElement('text', 'from')->setAttrib('class', 'selectdate');
        $submit=$this->createElement('submit','submit')->setAttrib('class','btn btn-info');
        $this->addElements(array($from,$submit));
    }

}

?>