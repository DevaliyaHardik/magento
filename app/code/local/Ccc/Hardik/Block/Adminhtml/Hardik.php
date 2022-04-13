<?php
 class Ccc_Hardik_Block_Adminhtml_Hardik extends Mage_Adminhtml_Block_Widget_Grid_Container
 {
 public function __construct()
 {
 $this->_controller = 'adminhtml_hardik';
 $this->_blockGroup = 'hardik';
 $this->_headerText = Mage::helper('hardik')->__('View Data');
 $this->_addButtonLabel = Mage::helper('hardik')->__('Add Student');
 parent::__construct();
 }
 }

 ?>