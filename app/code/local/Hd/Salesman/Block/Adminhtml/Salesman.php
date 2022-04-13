<?php
class Hd_Salesman_Block_Adminhtml_Salesman extends Mage_Adminhtml_Block_Widget_Grid_Container{

	public function __construct()
	{
		$this->_controller = 'adminhtml_salesman';
		$this->_blockGroup = 'salesman';
		$this->_headerText = Mage::helper('salesman')->__('View Data');
		$this->_addButtonLabel = Mage::helper('salesman')->('Add Salesman');
		parent::__construct();
	}
}

?>