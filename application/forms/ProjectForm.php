<?php

class Application_Form_ProjectForm extends Zend_Form {

    public function init() {
        $this->setAttrib('class','form-signin');
        $title = $this->createElement('text', 'title')->setRequired(true)->setAttrib('Placeholder', 'Project Title');
        $description = $this->createElement('text', 'description')->setRequired(true)->setAttrib('Placeholder', 'Description');
        $date_added = $this->createElement('text', 'date_added')->setAttrib('class', 'selectdate')->setRequired(true)->setAttrib('Placeholder', 'YYYY/MM/DD');
        $attachment = $this->createElement('file','attachment')->setAttrib('Placeholder', 'Choose a file');
        $attachment->setDestination(APPLICATION_PATH . '/../public/uploads')->setRequired(true);
        $user_id = $this->createElement('text', 'user_id')->setRequired(TRUE)->setAttrib('class','span1')->setAttrib('Placeholder', 'User ID');
        $submit = $this->createElement('submit', 'insert')->setRequired(true)->setAttrib('class', 'btn btn-primary');
        $this->addElements(array($title, $description, $date_added, $attachment, $user_id, $submit));
    }

}

?>