<?php
class Hd_Mfr_Block_Adminhtml_Mfr_Attribute_Grid extends Mage_Eav_Block_Adminhtml_Attribute_Grid_Abstract {

	protected function _prepareCollection() {
		$collection = Mage::getResourceModel('eav/entity_attribute_collection')->setEntityTypeFilter(Mage::getModel('eav/entity')->setType(Hd_Mfr_Model_Resource_Mfr::ENTITY)->getTypeId());
		$this->setCollection($collection);
		return parent::_prepareCollection();
	}

	protected function _prepareColumns() {
		parent::_prepareColumns();

		return $this;
	}

}