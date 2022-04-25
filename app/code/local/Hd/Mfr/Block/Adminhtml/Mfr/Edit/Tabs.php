<?php
class Hd_Mfr_Block_Adminhtml_Mfr_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

    public function __construct()
    {
        parent::__construct();
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('mfr')->__('Mfr Info.'));
    }

    public function getMfr() {
		return Mage::registry('current_mfr');
	}

	protected function _beforeToHtml() {
		$mfrAttributes = Mage::getResourceModel('eav/entity_attribute_collection')->setEntityTypeFilter(Mage::getModel('eav/entity')->setType(Hd_Mfr_Model_Resource_Mfr::ENTITY)->getTypeId());
		if (!$this->getMfr()->getId()) {
			foreach ($mfrAttributes as $attribute) {
				$default = $attribute->getDefaultValue();
				if ($default != null) {
					$this->getMfr()->setData($attribute->getAttributeCode(), $default);
				}
			}
		}

		$attributeSetId = $this->getMfr()->getResource()->getEntityType()->getDefaultAttributeSetId();

		$groupCollection = Mage::getResourceModel('eav/entity_attribute_group_collection')
			->setAttributeSetFilter($attributeSetId)
			->setSortOrder()
			->load();

		$defaultGroupId = 0;
		foreach ($groupCollection as $group) {
			if ($defaultGroupId == 0 || $group->getIsDefault()) {
				$defaultGroupId = $group->getId();
			}
			$attributes = [];
			foreach ($mfrAttributes as $attribute) {
				if ($this->getMfr()->checkInGroup($attribute->getId(), $attributeSetId, $group->getId())) {
					$attributes[] = $attribute;
				}
			}

			if (!$attributes) {
				continue;
			}

        $active = $defaultGroupId == $group->getId();

			$block = $this->getLayout()->createBlock('mfr/adminhtml_mfr_edit_tabs_attributes')
				->setGroup($group)
				->setAttributes($attributes)
				->setAddHiddenFields($active)
				->toHtml();
			$this->addTab('group_' . $group->getId(), [
				'label' => Mage::helper('mfr')->__($group->getAttributeGroupName()),
				'content' => $block,
				'active' => $active,
			]);
		}

		return parent::_beforeToHtml();

	}
}