<?php

class Application_Form_ForgotForm extends Zend_Form {

    public function init() {
       /* $obj = Zend_Controller_Front::getInstance();
        $pass = $obj->getParam('pass');
        $model = new Application_Model_team();
        $data = $model->fetchRow('pass');*/
        
        $form = new Zend_Form();
        $form = $this->setAttrib('class', 'form-signin');
        $code = $this->createElement('password', 'code')->setRequired(TRUE)->setAttrib('Placeholder', 'Enter Confimation Code')->setLabel('Old Password');
        $confirmpass = $this->createElement('password', 'confirmpass')->setRequired(TRUE)->setAttrib('Placeholder', 'Confirm Password')
                        ->addValidator('StringLength', FALSE, array(4))->setLabel('New Password');
        $pass = $this->createElement('password', 'pass')->setRequired(TRUE)->setAttrib('Placeholder', 'New Password')->addValidator('StringLength', false, array(4))
                        ->setLabel('Confirm Password')->addValidator('Identical', false, array('token' => 'confirmpass', 'messages' => 'Password do not match!'));
        $submit = $this->createElement('submit', 'submit')->setAttrib('class', 'btn btn-primary');
        $this->addElements(array($code, $confirmpass, $pass, $submit));
    }

}

?>
