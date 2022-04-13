<?php
class Hd_Salesman_Adminhtml_SalesmanController extends Mage_Adminhtml_Controller_Action{

	public function indexAction()
	{
        $this->_title($this->__('Salesman'))->_title($this->__('Salesman Groups'));

        $this->loadLayout();
        $this->_setActiveMenu('salesman/group');
        $this->_addBreadcrumb(Mage::helper('salesman')->__('Salesman'), Mage::helper('salesman')->__('Salesman'));
        $this->_addBreadcrumb(Mage::helper('salesman')->__('salesman Groups'), Mage::helper('salesman')->__('Salesman Groups'));
        $this->renderLayout();
	}
}

?>