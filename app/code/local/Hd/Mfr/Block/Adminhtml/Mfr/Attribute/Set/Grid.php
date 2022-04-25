<?php
class Hd_Mfr_Block_Adminhtml_Mfr_Attribute_Set_Grid extends Mage_Adminhtml_Block_Widget_Grid {

	protected function _prepareCollection() {
		$collection = Mage::getResourceModel('eav/entity_attribute_set_collection')
			->setEntityTypeFilter(Mage::registry('entityType'));

		$this->setCollection($collection);
		return parent::_prepareCollection();
	}

	protected function _prepareColumns() {
		$this->addColumn('set_name', array(
			'header' => Mage::helper('mfr')->__('Set Name'),
			'align' => 'left',
			'sortable' => true,
			'index' => 'attribute_set_name',
		));
	}

	public function getRowUrl($row) {
		return $this->getUrl('*/*/edit', array('id' => $row->getAttributeSetId()));
	}

}