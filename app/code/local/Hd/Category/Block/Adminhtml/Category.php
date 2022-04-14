<?php
class Hd_Category_Block_Adminhtml_Category extends Mage_Adminhtml_Block_Widget_Grid_Container{

    public function __construct()
    {
        $this->_controller = 'adminhtml_category';
        $this->_blockGroup = 'category';
        $this->_headerText = Mage::helper('category')->__('View Data');
        $this->_addButtonLabel = Mage::helper('category')->__('Add Category');
        parent::__construct();
    }
}

?>