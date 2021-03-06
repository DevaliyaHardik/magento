<?php
class Hd_Mfr_Block_Adminhtml_Mfr_Attribute_Edit_Form extends Mage_Adminhtml_Block_Widget_Form {

	protected function _prepareForm() {
		$form = new Varien_Data_Form([
			'id' => 'edit_form',
			'action' => $this->getUrl('*/*/save', ['id' => $this->getRequest()->getParam('id')]),
			'method' => 'post',
		]);

		$form->setUseContainer(true);
		$this->setForm($form);
		return parent::_prepareForm();
	}
}