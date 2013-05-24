<?php

class Application_Form_ReportForm extends Zend_Form {

    public function init() {
        $this->setAttrib('class', 'form-signin')->setAttrib('style', 'float:left');
        $user = new Application_Model_admin();
        $show = $user->fetchAll("account_type='Client'");
        $row = new Application_Model_project();
        $data = $row->fetchAll();
        $pickDate = $this->createElement('text', 'pickDate')
                ->setRequired(TRUE)
                ->setAttrib('class', 'daterangepicker')
                ->setAttrib('placeholder', 'Select Date')
                ->setLabel("Select Date : ");
        $title = $this->createElement('select', 'title')
                ->setLabel("Project Name : ");
        foreach ($data as $a) {
            $arr[$a->id] = $a->title;
        }
        $title->addMultiOption('', 'Select Project');
        $title->addMultiOptions($arr);
        $client = $this->createElement('select', 'account_type')
                ->setLabel("Client Name : ");
        foreach ($show as $v) {
            $array[$v->id] = $v->name;
        }
        $client->addMultiOption('', 'Select Client')
                ->addMultiOptions($array);

        $submit = $this->createElement('submit', 'submit')->setAttrib('class', 'btn btn-info');
        $this->addElements(array($client, $pickDate, $title, $submit));
    }

}

?>