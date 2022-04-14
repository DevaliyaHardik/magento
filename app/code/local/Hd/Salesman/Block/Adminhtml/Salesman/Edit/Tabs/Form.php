<?php

class Hd_Salesman_Block_Adminhtml_Salesman_Edit_Tabs_Form extends Mage_Adminhtml_Block_Widget_Form
 {
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('salesman_form', array('legend'=>Mage::helper('salesman')->__('Salesman information')));

        $fieldset->addField('name', 'text', array(
        'label' => Mage::helper('salesman')->__('Name'),
        'class' => 'required-entry',
        //'required' => true,
        //'readonly' => true,
        'name' => 'name',
        ));

        $fieldset->addField('email', 'text', array(
        'label' => Mage::helper('salesman')->__('Email'),
        'class' => 'required-entry',
        //'required' => true,
        'name' => 'email',
        //'readonly' => true,
        ));

        $fieldset->addField('mobile', 'text', array(
        'label' => Mage::helper('salesman')->__('Mobile'),
        'class' => 'required-entry',
        //'required' => true,
        'name' => 'mobile',
        //'readonly' => true,
        ));


        if ( Mage::getSingleton('adminhtml/session')->getProData() )
        {
        $form->setValues(Mage::getSingleton('adminhtml/session')->getProData());
        Mage::getSingleton('adminhtml/session')->setProData(null);
        } elseif ( Mage::registry('salesman_data') ) {
        $form->setValues(Mage::registry('salesman_data')->getData());
        }
        return parent::_prepareForm();
    }
 }