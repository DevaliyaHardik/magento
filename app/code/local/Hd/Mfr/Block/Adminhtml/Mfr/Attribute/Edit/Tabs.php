<?php
class Hd_Mfr_Block_Adminhtml_Mfr_Attribute_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs {

	public function __construct() {
		parent::__construct();
		$this->setId('mfr_attribute_tabs');
		$this->setDestElementId('edit_form');
		$this->setTitle(Mage::helper('mfr')->__('Attribute Information'));
	}

	protected function _beforeToHtml() {
		$this->addTab('main', array(
			'label' => Mage::helper('mfr')->__('Properties'),
			'title' => Mage::helper('mfr')->__('Properties'),
			'content' => $this->getLayout()->createBlock('mfr/adminhtml_mfr_attribute_edit_tab_main')->toHtml(),
			'active' => true,
		));

		$model = Mage::registry('entity_attribute');

		$this->addTab('labels', array(
			'label' => Mage::helper('mfr')->__('Manage Label / Options'),
			'title' => Mage::helper('mfr')->__('Manage Label / Options'),
			'content' => $this->getLayout()->createBlock('mfr/adminhtml_mfr_attribute_edit_tab_options')->toHtml(),
		));
		return parent::_beforeToHtml();
	}
}