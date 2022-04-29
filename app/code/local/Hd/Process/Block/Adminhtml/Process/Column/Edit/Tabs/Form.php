<?php

class Hd_Process_Block_Adminhtml_Process_Column_Edit_Tabs_Form extends Mage_Adminhtml_Block_Widget_Form
 {
    protected function getProcessOption()
    {
        $model = Mage::getModel('process/process');
        $select = $model->getCollection()
                ->getSelect()
                ->reset(Zend_Db_Select::COLUMNS)
                ->columns(['value' => 'process_id','label' => 'name']);
        return $model->getResource()->getReadConnection()->fetchAll($select);
    }

    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('process_form', array('legend'=>Mage::helper('process')->__('Process information')));

        $fieldset->addField('process_id', 'select', array(
            'label' => Mage::helper('process')->__('Process'),
            'class' => 'required-entry',
            'name' => 'process_id',
            'values' => $this->getProcessOption(),
        ));

        $fieldset->addField('name', 'text', array(
            'label' => Mage::helper('process')->__('Name'),
            'class' => 'required-entry',
            'name' => 'name',
        ));

        $fieldset->addField('sampleData', 'text', array(
            'label' => Mage::helper('process')->__('Sample Data'),
            'class' => 'required-entry',
            'name' => 'sampleData',
        ));

        $fieldset->addField('required', 'select', array(
            'label' => Mage::helper('process')->__('Required'),
            'class' => 'required-entry',
            'name' => 'required',
            'values' => [
                ['value' => 1,'label' => 'Yes'],
                ['value' => 0,'label' => 'No'],
            ],
        ));

        $fieldset->addField('castingType', 'select', array(
            'label' => Mage::helper('process')->__('Casting Type'),
            'class' => 'required-entry',
            'name' => 'castingType',
            'values' => [
                ['value' => Hd_Process_Model_Column::CASTING_INTEGER,'label' => Mage::helper('process')->__('Integer')],
                ['value' => Hd_Process_Model_Column::CASTING_DESIMAL,'label' => Mage::helper('process')->__('Desimal')],
                ['value' => Hd_Process_Model_Column::CASTING_VARCHAR,'label' => Mage::helper('process')->__('Varchar')],
            ],

        ));

        $fieldset->addField('exception', 'text', array(
            'label' => Mage::helper('process')->__('Exception'),
            'class' => 'required-entry',
            'name' => 'exception',
        ));    

        if ( Mage::getSingleton('adminhtml/session')->getColumnData() )
        {
        $form->setValues(Mage::getSingleton('adminhtml/session')->getColumnData());
        Mage::getSingleton('adminhtml/session')->setProData(null);
        } elseif ( Mage::registry('current_process_column') ) {
        $form->setValues(Mage::registry('current_process_column')->getData());
        }
        return parent::_prepareForm();
    }
 }