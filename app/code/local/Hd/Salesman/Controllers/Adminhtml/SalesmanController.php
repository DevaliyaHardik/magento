<?php
class Hd_Salesman_Adminhtml_SalesmanController extends Mage_Adminhtml_Controller_Action{

    public function indexAction()
    {
        $this->_title($this->__('Salesman'))->_title($this->__('Salesman Info'));
        $this->loadLayout();
        $this->_setActiveMenu('salesman/group');
        $this->renderLayout();
    }
}

?>