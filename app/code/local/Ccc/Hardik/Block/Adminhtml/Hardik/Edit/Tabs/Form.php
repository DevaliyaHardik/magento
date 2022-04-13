<?php

class Ccc_Hardik_Block_Adminhtml_Hardik_Edit_Tabs_Form extends Mage_Adminhtml_Block_Widget_Form
 {
 protected function _prepareForm()
 {
 $form = new Varien_Data_Form();
 $this->setForm($form);
 $fieldset = $form->addFieldset('hardik_form', array('legend'=>Mage::helper('hardik')->__('Student information')));

$fieldset->addField('stdname', 'text', array(
 'label' => Mage::helper('hardik')->__('Name'),
 'class' => 'required-entry',
 //'required' => true,
 //'readonly' => true,
 'name' => 'stdname',
 ));

$fieldset->addField('email', 'text', array(
 'label' => Mage::helper('hardik')->__('Email'),
 'class' => 'required-entry',
 //'required' => true,
 'name' => 'email',
 //'readonly' => true,
 ));

$fieldset->addField('rollno', 'text', array(
 'label' => Mage::helper('hardik')->__('Roll No'),
 'class' => 'required-entry',
 //'required' => true,
 'name' => 'rollno',
 //'readonly' => true,
 ));

$fieldset->addField('status', 'select', array(
 'label' => Mage::helper('hardik')->__('Status'),
 'name' => 'status',
 'values' => array(
 array(
 'value' => 1,
 'label' => Mage::helper('hardik')->__('Active'),
 ),

array(
 'value' => 0,
 'label' => Mage::helper('hardik')->__('Inactive'),
 ),
 ),
 ));

if ( Mage::getSingleton('adminhtml/session')->getProData() )
 {
 $form->setValues(Mage::getSingleton('adminhtml/session')->getProData());
 Mage::getSingleton('adminhtml/session')->setProData(null);
 } elseif ( Mage::registry('hardik_data') ) {
 $form->setValues(Mage::registry('hardik_data')->getData());
 }
 return parent::_prepareForm();
 }
 }