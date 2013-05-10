<?php

class Application_Form_TaskForm extends Zend_Form {

    public function init() {
        $name = $this->createElement('text', 'title')->setAttrib('Placeholder', 'Title')->setLabel('Title :- ')->setRequired(true);
        $description = $this->createElement('textarea', 'description')->setRequired(true)->setAttribs(array('rows' => 5, 'cols' => 5))->setAttrib('placeholder', 'Add Description')->setLabel('Add Description');
        $add = $this->createElement('text', 'added_by')->setAttrib('placeholder', 'Added By')->setLabel('Added By :- ')->setRequired(true);
        $assign = $this->createElement('text', 'assign_to')->setAttrib('placeholder', 'Assign To')->setLabel('Assign To :- ')->setRequired(true);
        $time_added = $this->createElement('text', 'time_added')->setAttrib('placeholder', 'HH:mm:ss')->setLabel('Time Added :- ');
        $time_completed = $this->createElement('text', 'time_completed')->setAttrib('placeholder', 'HH:mm:ss')->setLabel('Time Completed :- ');
        $file = new Zend_Form_Element_File('attachment');
        $file->setDestination(APPLICATION_PATH . '/../public/uploads')
                ->setRequired(true);
        $submit = $this->createElement('submit', 'submit')->setAttrib('class', 'btn btn-primary');
        $this->addElements(array($name, $description, $add, $assign, $time_added, $time_completed, $file, $submit));
    }

}

?>
