<?php
class Hd_Category_Adminhtml_CategoryController extends Mage_Adminhtml_Controller_Action{

    public function indexAction()
    {
        $this->_title($this->__('Categorys'))->_title($this->__('Category Groups'));
        $this->loadLayout();
        $this->_setActiveMenu('category/group');
        $this->renderLayout();
    }

    public function editAction()
    {
        $categoryId = $this->getRequest()->getParam('id');
        $categoryModel = Mage::getModel('category/category')->load($categoryId);

        if($categoryModel->getId() || $categoryId == 0){
            Mage::register('category_data', $categoryModel);
            $this->loadLayout();
            $this->_setActiveMenu('category/category');
            $this->_addContent($this->getLayout()->createBlock('category/adminhtml_category_edit'))
			->_addLeft($this->getLayout()->createBlock('category/adminhtml_category_edit_tabs'));

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
        $categoryId = $this->getRequest()->getParam('id');
        $categoryModel = Mage::getModel('category/category');
        $postData = $this->getRequest()->getPost();
        $categoryModel->setId($categoryId)
        ->setName($postData['name'])
        ->save();
        $this->_redirect('*/*/');

    }

    public function deleteAction()
    {
        if($this->getRequest()->getParam('id')){
            $categoryModel = Mage::getModel('category/category');
            $categoryModel->load($this->getRequest()->getParam('id'))->delete();
            $this->_redirect('*/*/');
        }
    }

}

?>