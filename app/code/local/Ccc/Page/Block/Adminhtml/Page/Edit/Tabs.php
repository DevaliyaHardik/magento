<?php
class Ccc_Page_Block_Adminhtml_Page_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('page_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('page')->__('Page Information'));
    }

    protected function _beforeToHtml()
    {
        $this->addTab('form_section', array(
        'label' => Mage::helper('page')->__('Page Data'),
        'name' => Mage::helper('page')->__('Page Name'),
        'code' => Mage::helper('page')->__('Page Code'),
        'value' => Mage::helper('page')->__('Page Value'),
        'content' => $this->getLayout()->createBlock('page/adminhtml_page_edit_tabs_form')->toHtml(),
        ));

        return parent::_beforeToHtml();
    }
}

?>