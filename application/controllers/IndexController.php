<?php

class IndexController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    public function indexAction() {

    }
 public function dashAction() {
       $form = new Application_Form_IndexForm();
        $this->view->form = $form;
    }
}