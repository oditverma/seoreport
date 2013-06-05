<?php

class Application_Form_TaskForm extends Zend_Form {

    public function init() {
        $title = $this->createElement('text', 'title')
                ->setAttrib('Placeholder', 'Title')
                ->setLabel('Title : ');
        $description = $this->createElement('textarea', 'description')
                ->setAttribs(array('rows' => 5, 'cols' => 5, 'placeholder' => 'Add Description'))
                ->setLabel('Add Description');
        $add = $this->createElement('text', 'added_by')
                ->setAttrib('placeholder', 'Added By')
                ->setLabel('Added By : ');
        $assign = $this->createElement('text', 'assign_to')
                ->setAttrib('placeholder', 'Assign To')
                ->setLabel('Assign To :- ');
        $time_added = $this->createElement('text', 'time_added')
                ->setAttrib('placeholder', 'yyyy/MM/dd HH:mm:ss PP')
                ->setAttrib('data-format', 'yyyy/MM/dd HH:mm:ss PP')
                ->setDecorators(array('ViewHelper'));
        $time_completed = $this->createElement('text', 'time_completed')
                ->setAttrib('placeholder', 'yyyy/MM/dd HH:mm:ss PP')
                ->setAttrib('data-format', 'yyyy/MM/dd HH:mm:ss PP')
                ->setDecorators(array('ViewHelper'));
        $file = new Zend_Form_Element_File('attachment');
        $file->setDestination(APPLICATION_PATH . '/../public/uploads');
        $submit = $this->createElement('submit', 'submit')
                ->setAttrib('class', 'btn btn-primary');
        $this->addElements(array($title, $description, $add, $assign, $time_added, $time_completed, $file, $submit));
    }

}

?>
