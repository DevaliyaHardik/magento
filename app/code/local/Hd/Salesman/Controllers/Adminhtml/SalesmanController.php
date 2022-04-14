<?php

class Hd_Salesman_Adminhtml_SalesmanController extends Mage_Adminhtml_Controller_Action
 {
    public function indexAction() {
        $this->_title($this->__('Salesmans'))->_title($this->__('Salesman Groups'));

        $this->loadLayout();
        $this->_setActiveMenu('salesman/group');
        $this->renderLayout();
    }

    public function editAction()
    {
        $salesmanId = $this->getRequest()->getParam('id');
        $salesmanModel = Mage::getModel('salesman/salesman')->load($salesmanId);

        if($salesmanModel->getId() || $salesmanId == 0){
            Mage::register('salesman_data', $salesmanModel);
            $this->loadLayout();
            $this->_setActiveMenu('salesman/salesman');
            $this->_addContent($this->getLayout()->createBlock('salesman/adminhtml_salesman_edit'))
			->_addLeft($this->getLayout()->createBlock('salesman/adminhtml_salesman_edit_tabs'));

            $this->renderLayout();
        }
        else{
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('page')->__('Item does not exist'));
            $this->_redirect('*/*/');
        }
    }

    public function newAction()
    {
        $this->_forward('edit');
    }

    public function saveAction()
    {
        $salesmanId = $this->getRequest()->getParam('id');
        $salesmanModel = Mage::getModel('salesman/salesman');
        $postData = $this->getRequest()->getPost();
        $salesmanModel->setId($salesmanId)
        ->setName($postData['name'])
        ->setEmail($postData['email'])
        ->setMobile($postData['mobile'])
        ->save();
        $this->_redirect('*/*/');

    }

    public function deleteAction()
    {
        if($this->getRequest()->getParam('id')){
            $salesmanModel = Mage::getModel('salesman/salesman');
            $salesmanModel->load($this->getRequest()->getParam('id'))->delete();
            $this->_redirect('*/*/');
        }
    }
}

?>

