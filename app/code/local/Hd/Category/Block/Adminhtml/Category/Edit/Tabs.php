<?php
class Hd_Category_Block_Adminhtml_Category_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('category_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('category')->__('Category Information'));
    }

    protected function _beforeToHtml()
    {
        $this->addTab('form_section', array(
        'label' => Mage::helper('category')->__('Category Data'),
        'name' => Mage::helper('category')->__('Category Name'),
        'content' => $this->getLayout()->createBlock('category/adminhtml_category_edit_tabs_form')->toHtml(),
        ));

        return parent::_beforeToHtml();
    }
}

?>