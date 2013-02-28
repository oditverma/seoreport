<?php

class Application_Form_TaskForm extends Zend_Form {

    public function init() {
        $name = $this->createElement('text', 'name')->setAttrib('Placeholder', 'name')->setLabel('Name : ')->setRequired(true);
        $add = $this->createElement('text', 'added_by')->setAttrib('placeholder', 'Added by')->setLabel('Added By: ')->setRequired(true);
        $assign = $this->createElement('text', 'assign_to')->setAttrib('placeholder', 'Assign to')->setLabel('Assign To: ')->setRequired(true);
        $time = $this->createElement('text', 'date_added')->setAttrib('placeholder', 'Time added')
                        ->setLabel('Time Added : ')->setRequired(true)->setValue(date("Y-m-d h:i:s"));
          $file = new Zend_Form_Element_File('file');
        $file->setDestination(APPLICATION_PATH . '/../public/uploads')
                ->setRequired(true);
        $submit = $this->createElement('submit', 'submit')->setAttrib('class', 'btn btn-primary');
        $this->addElements(array($name, $add, $assign, $time,$file,$submit));
    }

}

?>
