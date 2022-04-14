<?php
class Hd_Salesman_Block_Adminhtml_Salesman_Edit extends Mage_Adminhtml_Block_Widget_Form_Container{

    public function __construct()
    {
        parent::__construct();
        $this->_objectId = 'id';
        $this->_blockGroup = 'salesman';
        $this->_controller = 'adminhtml_salesman';
        $this->_updateButton('save', 'label', Mage::helper('salesman')->__('Save Data'));
        $this->_updateButton('delete', 'label', Mage::helper('salesman')->__('Delete Item'));
    }

    public function getHeaderText()
    {
        if( Mage::registry('salesman_data') && Mage::registry('salesman_data')->getId() ) {
        return Mage::helper('salesman')->__("View Salesman Data", $this->htmlEscape(Mage::registry('salesman_data')->getTitle()));
        } else {
        return Mage::helper('salesman')->__('Salesman Information');
    }
    }

}

?>