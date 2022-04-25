<?php

class Hd_Mfr_Block_Adminhtml_Mfr_Attribute_Edit extends Mage_Adminhtml_Block_Widget_Form_Container {

	public function __construct() {
		$this->_objectId = 'attribute_id';
		$this->_controller = 'adminhtml_mfr_attribute';
		$this->_blockGroup = 'mfr';
		$this->_headerText = 'Attribute';
		parent::__construct();

	}

}