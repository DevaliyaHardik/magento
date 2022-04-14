<?php
 class Ccc_Page_Block_Adminhtml_Page extends Mage_Adminhtml_Block_Widget_Grid_Container
 {
    public function __construct()
    {
        $this->_controller = 'adminhtml_page';
        $this->_blockGroup = 'page';
        $this->_headerText = Mage::helper('page')->__('View Data');
        $this->_addButtonLabel = Mage::helper('page')->__('Add Page');
        parent::__construct();
    }
 }

 ?>