<?php
class Hd_Category_Block_Adminhtml_Category_Edit extends Mage_Adminhtml_Block_Widget_Form_Container{

    public function __construct()
    {
        parent::__construct();
        $this->_objectId = 'id';
        $this->_blockGroup = 'category';
        $this->_controller = 'adminhtml_category';
        $this->_updateButton('save', 'label', Mage::helper('category')->__('Save Data'));
        $this->_updateButton('delete', 'label', Mage::helper('category')->__('Delete Item'));
    }

    public function getHeaderText()
    {
        if( Mage::registry('category_data') && Mage::registry('category_data')->getId() ) {
        return Mage::helper('category')->__("View Category Data", $this->htmlEscape(Mage::registry('category_data')->getTitle()));
        } else {
        return Mage::helper('category')->__('Category Information');
    }
    }

}

?>