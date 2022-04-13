<?php
class Ccc_Hardik_Block_Adminhtml_Hardik_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

public function __construct()
{
parent::__construct();
$this->setId('hardik_tabs');
$this->setDestElementId('edit_form');
$this->setTitle(Mage::helper('hardik')->__('Student Information'));
}

protected function _beforeToHtml()
{
$this->addTab('form_section', array(
'label' => Mage::helper('hardik')->__('Student Data'),
'stdname' => Mage::helper('hardik')->__('Student Name'),
'email' => Mage::helper('hardik')->__('Student Email'),
'rollno' => Mage::helper('hardik')->__('Student Roll No'),
'content' => $this->getLayout()->createBlock('hardik/adminhtml_hardik_edit_tabs_form')->toHtml(),
));

return parent::_beforeToHtml();
}
}

?>