<?php

class Evozon_Helloworld_IndexController extends Mage_Core_Controller_Front_Action {        
    public function indexAction() {
        //echo 'Hello World';
        $this->loadLayout();
        $this->renderLayout();
    }
    
    public function goodbyeAction() {
    //echo 'Goodbye World!';
        $this->loadLayout();
        $this->renderLayout();
}
}
