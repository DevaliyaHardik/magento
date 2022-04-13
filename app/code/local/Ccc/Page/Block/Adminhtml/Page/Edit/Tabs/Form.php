<?php

class Ccc_Page_Block_Adminhtml_Page_Edit_Tabs_Form extends Mage_Adminhtml_Block_Widget_Form
 {
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('page_form', array('legend'=>Mage::helper('page')->__('Page information')));

        $fieldset->addField('name', 'text', array(
        'label' => Mage::helper('page')->__('Name'),
        'class' => 'required-entry',
        //'required' => true,
        //'readonly' => true,
        'name' => 'name',
        ));

        $fieldset->addField('code', 'text', array(
        'label' => Mage::helper('page')->__('Code'),
        'class' => 'required-entry',
        //'required' => true,
        'name' => 'code',
        //'readonly' => true,
        ));

        $fieldset->addField('value', 'text', array(
        'label' => Mage::helper('page')->__('Value'),
        'class' => 'required-entry',
        //'required' => true,
        'name' => 'value',
        //'readonly' => true,
        ));


        if ( Mage::getSingleton('adminhtml/session')->getProData() )
        {
        $form->setValues(Mage::getSingleton('adminhtml/session')->getProData());
        Mage::getSingleton('adminhtml/session')->setProData(null);
        } elseif ( Mage::registry('page_data') ) {
        $form->setValues(Mage::registry('page_data')->getData());
        }
        return parent::_prepareForm();
    }
 }