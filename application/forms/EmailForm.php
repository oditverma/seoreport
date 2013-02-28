<?php

class Application_Form_EmailForm extends Zend_Form {

    public function init() {
            $form = new Zend_form();
        $form = $this->setAttrib('class', 'form-signin');
        $email = $this->createElement('text', 'email')->setRequired(TRUE)
                ->setAttrib('placeholder', 'Email')
                ->setLabel('E-mail : ')->addFilters(array('StringTrim', 'StripTags'))
                ->addValidator('EmailAddress', TRUE);
/*                ->addValidator(new Zend_Validate_Db_NoRecordExists(
                array('adapter' => Zend_Db_Table::getDefaultAdapter(),'table'=>'team','field'=>'email', TRUE)));
*/        $submit = $this->createElement('submit', 'submit')->setAttrib('class', 'btn btn-primary');
        $this->addElements(array($email, $submit));
    }

}
?>
