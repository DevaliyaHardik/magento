<?php

class Hd_Vendor_Block_Adminhtml_Vendor_Index_Edit extends Mage_Adminhtml_Block_Widget_Form_Container 
{
    
    public function __construct()
    {
        parent::__construct();
        $this->_objectId = 'id';
        $this->_blockGroup = 'vendor';
        $this->_controller = 'adminhtml_vendor_index';

        $this->_updateButton('save', 'label', Mage::helper('vendor')->__('Save Data'));
        $this->_updateButton('delete', 'label', Mage::helper('vendor')->__('Delete Item'));
    }

    public function getHeaderText()
    {
        if (Mage::registry('vendor_data')->getId()) {
            return Mage::helper('vendor')->__('Edit Vendor');
        }
        else 
        {
            return Mage::helper('vendor')->__('New Vendor');
        }
    }
}
