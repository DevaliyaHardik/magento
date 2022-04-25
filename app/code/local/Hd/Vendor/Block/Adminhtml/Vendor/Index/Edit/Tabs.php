<?php

class Hd_Vendor_Block_Adminhtml_Vendor_Index_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('vendor_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('vendor')->__('Vendor Info.'));
    }

    protected function _beforeToHtml()
    {
        $this->addTab('form_section', array(
            'label' => Mage::helper('vendor')->__('Vendor Info.'),
            'content' => $this->getLayout()->createBlock('vendor/adminhtml_vendor_index_edit_tab_form')->toHtml(),
        ));
        return parent::_beforeToHtml();
    }
 }