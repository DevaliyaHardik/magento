<?php

class Hd_Process_Block_Adminhtml_Process_Entry_Edit_Tabs_Form extends Mage_Adminhtml_Block_Widget_Form
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

    // protected function getStartDate()
    // {
    //     print_r(explode(':',Mage::registry('current_process_entry')->getData()['startTime']));
    //     return explode(':',Mage::registry('current_process_entry')->getData()['startTime']);
    // }

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

        $fieldset->addField('identifier', 'text', array(
            'label' => Mage::helper('process')->__('Identifier'),
            'class' => 'required-entry',
            'name' => 'identifier',
        ));

        $fieldset->addField('startTime', 'time', array(
            'label' => Mage::helper('process')->__('Start Time'),
            'class' => 'required-entry',
            'name' => 'startTime',
        ));

        $fieldset->addField('endTime', 'time', array(
            'label' => Mage::helper('process')->__('End Time'),
            'class' => 'required-entry',
            'name' => 'endTime',
        ));

        $fieldset->addField('data', 'text', array(
            'label' => Mage::helper('process')->__('Data'),
            'class' => 'required-entry',
            'name' => 'data',
        ));    

        if ( Mage::getSingleton('adminhtml/session')->getProData() ){
            $form->setValues(Mage::getSingleton('adminhtml/session')->getProData());
            Mage::getSingleton('adminhtml/session')->setProData(null);
        } elseif ( Mage::registry('current_process_entry') ) {
            $form->setValues(Mage::registry('current_process_entry')->getData());
        }
        return parent::_prepareForm();
    }
 }