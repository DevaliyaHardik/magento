<?php

class Hd_Salesman_Adminhtml_SalesmanController extends Mage_Adminhtml_Controller_Action
 {
    public function indexAction() {
        $this->_title($this->__('Salesmans'))->_title($this->__('Salesman Groups'));

        $this->loadLayout();
        $this->_setActiveMenu('salesman/group');
        $this->_addBreadcrumb(Mage::helper('salesman')->__('Salesmans'), Mage::helper('salesman')->__('Salesmans'));
        $this->_addBreadcrumb(Mage::helper('salesman')->__('Salesman Groups'), Mage::helper('salesman')->__('Salesman Groups'));
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
        echo $salesmanId;
        exit;
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

