<?php

class Ccc_Hardik_Adminhtml_HardikController extends Mage_Adminhtml_Controller_Action
 {

protected function _initAction()
 {
 $this->loadLayout()
 ->_setActiveMenu('hardik/hardik')
 ->_addBreadcrumb(Mage::helper('adminhtml')->__('Data Manager'), Mage::helper('adminhtml')->__('Data Manager'));
 return $this;
 }

public function indexAction() {
 $this->_initAction();
 $this->_addContent($this->getLayout()->createBlock('hardik/adminhtml_hardik'));
 $this->renderLayout();
 }

public function editAction()
 {
 $hardikId = $this->getRequest()->getParam('id');

$hardikModel = Mage::getModel('hardik/hardik')->load($hardikId);

if ($hardikModel->getId() || $hardikId == 0) {

Mage::register('hardik_data', $hardikModel);

$this->loadLayout();
 $this->_setActiveMenu('hardik/hardik');

$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Student Information'), Mage::helper('adminhtml')->__('Studenet Information'));
 $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Data News'), Mage::helper('adminhtml')->__('Data News'));

$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

$this->_addContent($this->getLayout()->createBlock('hardik/adminhtml_hardik_edit'))
 ->_addLeft($this->getLayout()->createBlock('hardik/adminhtml_hardik_edit_tabs'));

$this->renderLayout();
 } else {
 Mage::getSingleton('adminhtml/session')->addError(Mage::helper('hardik')->__('Item does not exist'));
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
 $hardikModel = Mage::getModel('hardik/hardik');

$hardikModel->setId($this->getRequest()->getParam('id'))
 ->setStdname($postData['stdname'])
 ->setEmail($postData['email'])
 ->setRollno($postData['rollno'])
 ->setStatus($postData['status'])
 ->save();

Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Data was successfully saved'));
 Mage::getSingleton('adminhtml/session')->sethardikData(false);

$this->_redirect('*/*/');
 return;
 } catch (Exception $e) {
 Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
 Mage::getSingleton('adminhtml/session')->sethardikData($this->getRequest()->getPost());
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
 $hardikModel = Mage::getModel('hardik/hardik');

$hardikModel->setId($this->getRequest()->getParam('id'))
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
 $this->getLayout()->createBlock('hardik/adminhtml_hardik_grid')->toHtml()
 );
 }
 }

 ?>