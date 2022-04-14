<?php

class Ccc_Hardik_Block_Adminhtml_Hardik_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
 {
 public function __construct()
 {
 parent::__construct();
 $this->_objectId = 'id';
 $this->_blockGroup = 'hardik';
 $this->_controller = 'adminhtml_hardik';

$this->_updateButton('save', 'label', Mage::helper('hardik')->__('Save Data'));
 $this->_updateButton('delete', 'label', Mage::helper('hardik')->__('Delete Item'));
 }

public function getHeaderText()
 {
 if( Mage::registry('hardik_data') && Mage::registry('hardik_data')->getId() ) {
 return Mage::helper('hardik')->__("View Student Data '%s'", $this->htmlEscape(Mage::registry('hardik_data')->getTitle()));
 } else {
 return Mage::helper('hardik')->__('Student Information');
 }
 }
 }

 ?>