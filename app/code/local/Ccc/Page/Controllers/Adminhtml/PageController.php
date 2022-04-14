<?php

class Ccc_Page_Adminhtml_PageController extends Mage_Adminhtml_Controller_Action
 {
    public function indexAction() {
        $this->_title($this->__('Pages'))->_title($this->__('Page Groups'));

        $this->loadLayout();
        $this->_setActiveMenu('page/group');
        $this->_addBreadcrumb(Mage::helper('page')->__('Pages'), Mage::helper('page')->__('Pages'));
        $this->_addBreadcrumb(Mage::helper('page')->__('Page Groups'), Mage::helper('page')->__('Page Groups'));
        $this->renderLayout();
    }

    public function editAction()
    {
        $pageId = $this->getRequest()->getParam('id');

        $pageModel = Mage::getModel('page/page')->load($pageId);

        if ($pageModel->getId() || $pageId == 0) {

            Mage::register('page_data', $pageModel);

            $this->loadLayout();
            $this->_setActiveMenu('page/page');

            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Page Information'), Mage::helper('adminhtml')->__('Page Information'));
            //$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Data News'), Mage::helper('adminhtml')->__('Data News'));

            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

            $this->_addContent($this->getLayout()->createBlock('page/adminhtml_page_edit'))
            ->_addLeft($this->getLayout()->createBlock('page/adminhtml_page_edit_tabs'));

            $this->renderLayout();
        } else {
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
        if ( $this->getRequest()->getPost() ) {
            try {
                $postData = $this->getRequest()->getPost();
                $pageModel = Mage::getModel('page/page');

                $pageModel->setId($this->getRequest()->getParam('id'))
                ->setName($postData['name'])
                ->setCode($postData['code'])
                ->setValue($postData['value'])
                ->save();

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Data was successfully saved'));
                Mage::getSingleton('adminhtml/session')->setpageData(false);

                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setpageData($this->getRequest()->getPost());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        $this->_redirect('*/*/');
    }

    public function deleteAction()
    {
    if( $this->getRequest()->getParam('id') > 0 ) {
    try {
    $pageModel = Mage::getModel('page/page');

    $pageModel->setId($this->getRequest()->getParam('id'))
    ->delete();

    Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Data was successfully deleted'));
    $this->_redirect('*/*/');
    } catch (Exception $e) {
    Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
    $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
    }
    }
    $this->_redirect('*/*/');
    }
    /**
     * Product grid for AJAX request.
     * Sort and filter result for example.
     */
    public function gridAction()
    {
    $this->loadLayout();
    $this->getResponse()->setBody(
    $this->getLayout()->createBlock('page/adminhtml_page_grid')->toHtml()
    );
    }


 }