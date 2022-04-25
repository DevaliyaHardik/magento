<?php 
class Hd_Mfr_Block_Adminhtml_Mfr extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'mfr';
        $this->_controller = 'adminhtml_mfr';
        $this->_headerText = Mage::helper('mfr')->__('Manage Mfr');
        // $this->_addButtonLabel = Mage::helper('mfr')->__('Add New Mfr');
        parent::__construct();
    }
}
