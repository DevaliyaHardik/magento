<?php

class Ccc_Page_Block_Adminhtml_Page_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
 {
    public function __construct()
    {
        parent::__construct();
        $this->_objectId = 'id';
        $this->_blockGroup = 'page';
        $this->_controller = 'adminhtml_page';
        $this->_updateButton('save', 'label', Mage::helper('page')->__('Save Data'));
        $this->_updateButton('delete', 'label', Mage::helper('page')->__('Delete Item'));
    }

    public function getHeaderText()
    {
        if( Mage::registry('page_data') && Mage::registry('page_data')->getId() ) {
        return Mage::helper('page')->__("View Page Data", $this->htmlEscape(Mage::registry('page_data')->getTitle()));
        } else {
        return Mage::helper('page')->__('Page Information');
    }
    }
 }

 ?>