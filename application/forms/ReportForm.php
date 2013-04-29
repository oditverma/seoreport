<?php

class Application_Form_ReportForm extends Zend_Form {

    public function init() {
        $this->setAttrib('class', 'bs-docs-example')->setAttrib('style', 'float:left');
        $row = new Application_Model_project();
        $data = $row->fetchAll();
        $pickDate = $this->createElement('text', 'pickDate')->setAttrib('class', 'daterangepicker')->setAttrib('placeholder', 'Select Date')->setLabel("Select Date :- ")->setRequired(TRUE);
        $title = $this->createElement('select', 'title')
                        ->setRequired(TRUE)->setLabel("Campaign Name :- ");
        foreach ($data as $a) {
            $arr[$a->title] = $a->title;
        }
        $title->addMultiOption('', 'Select Project');
        $title->addMultiOptions($arr);

        $submit = $this->createElement('submit', 'submit')->setAttrib('class', 'btn btn-info');
        $this->addElements(array($pickDate, $title, $submit));
    }

}

?>