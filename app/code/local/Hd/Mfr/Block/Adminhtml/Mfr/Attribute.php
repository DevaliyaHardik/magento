<?php
class Hd_Mfr_Block_Adminhtml_Mfr_Attribute extends Mage_Adminhtml_Block_Widget_Grid_Container {
	public function __construct() {
		$this->_controller = 'adminhtml_mfr_attribute';
		$this->_blockGroup = 'mfr';
		$this->_headerText = 'Manage Attribute';
		parent::__construct();
	}
}