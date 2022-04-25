<?php
class Hd_Mfr_Block_Adminhtml_Mfr_Edit extends Mage_Adminhtml_Block_Widget_Form_Container 
{
    
    public function __construct()
    {
        parent::__construct();
        $this->_blockGroup = 'mfr';
        $this->_controller = 'adminhtml_mfr';
        $this->_headerText = 'Edit Mfr';
    }
}
