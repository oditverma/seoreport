<?php

class Application_Form_TaskForm extends Zend_Form {

    public function init() {
        $this->setAttrib('class', 'form-signin');
        $name = $this->createElement('text', 'title')->setAttrib('Placeholder', 'name')->setLabel('Name :- ')->setRequired(true);
        $description = $this->createElement('textarea', 'description')->setRequired(true)->setAttribs(array('rows' => 5, 'cols' => 5))->setAttrib('placeholder', 'Add Description')->setLabel('Add Description');
        $add = $this->createElement('text', 'added_by')->setAttrib('placeholder', 'Added by')->setLabel('Added By :- ')->setRequired(true);
        $assign = $this->createElement('text', 'assign_to')->setAttrib('placeholder', 'Assign to')->setLabel('Assign To :- ')->setRequired(true);
        $time_completed = $this->createElement('text', 'time_completed')->setAttrib('placeholder', 'Time completed')->setLabel('Time Completed :- ');
        $file = new Zend_Form_Element_File('attachment');
        $file->setDestination(APPLICATION_PATH . '/../public/uploads')
                ->setRequired(true);
        $submit = $this->createElement('submit', 'submit')->setAttrib('class', 'btn btn-primary');
        $this->addElements(array($name, $description, $add, $assign, $time_completed, $file, $submit));
    }

}

?>
