<?php
class Hd_Salesman_Block_Adminhtml_Salesman_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('salesman_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('salesman')->__('Salesman Information'));
    }

    protected function _beforeToHtml()
    {
        $this->addTab('form_section', array(
        'label' => Mage::helper('salesman')->__('Salesman Data'),
        'name' => Mage::helper('salesman')->__('Salesman Name'),
        'email' => Mage::helper('salesman')->__('Salesman Email'),
        'mobile' => Mage::helper('salesman')->__('Salesman Mobile'),
        'content' => $this->getLayout()->createBlock('salesman/adminhtml_salesman_edit_tabs_form')->toHtml(),
        ));

        return parent::_beforeToHtml();
    }
}

?>