<?php

class Hd_Category_Block_Adminhtml_Category_Edit_Tabs_Form extends Mage_Adminhtml_Block_Widget_Form
 {
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('category_form', array('legend'=>Mage::helper('category')->__('Category information')));

        $fieldset->addField('name', 'text', array(
        'label' => Mage::helper('category')->__('Name'),
        'class' => 'required-entry',
        //'required' => true,
        //'readonly' => true,
        'name' => 'name',
        ));

        if ( Mage::getSingleton('adminhtml/session')->getProData() )
        {
        $form->setValues(Mage::getSingleton('adminhtml/session')->getProData());
        Mage::getSingleton('adminhtml/session')->setProData(null);
        } elseif ( Mage::registry('category_data') ) {
        $form->setValues(Mage::registry('category_data')->getData());
        }
        return parent::_prepareForm();
    }
 }