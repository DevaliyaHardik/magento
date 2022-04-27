<?php
class Hd_Process_Block_Adminhtml_Process_Edit_Tabs_Form extends Mage_Adminhtml_Block_Widget_Form
 {

    protected function getGroupOption()
    {
        $model = Mage::getModel('process/group');
        $select = $model->getCollection()
                ->getSelect()
                ->reset(Zend_Db_Select::COLUMNS)
                ->columns(['value' =>'group_id', 'label' => 'name']);
        return $model->getResource()->getReadConnection()->fetchAll($select);
    }

    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('process_form', array('legend'=>Mage::helper('process')->__('Process information')));

        $fieldset->addField('group_id', 'select', array(
        'label' => Mage::helper('process')->__('Group'),
        'class' => 'required-entry',
        'name' => 'group_id',
        'values' => $this->getGroupOption(),
        ));

        $fieldset->addField('type_id', 'select', array(
            'label' => Mage::helper('process')->__('Type'),
            'class' => 'required-entry',
            'name' => 'type_id',
            'values' => [
                ['value'=>Hd_Process_Model_Process::TYPE_IMPORT,
                'label'=>Mage::helper('process')->__('Import')],
                ['value'=>Hd_Process_Model_Process::TYPE_EXPORT,
                'label'=>Mage::helper('process')->__('Export')],
                ['value'=>Hd_Process_Model_Process::TYPE_CORN,
                'label'=>Mage::helper('process')->__('Corn')],
            ],
        ));

        $fieldset->addField('name', 'text', array(
            'label' => Mage::helper('process')->__('Name'),
            'class' => 'required-entry',
            'name' => 'name',
        ));

        $fieldset->addField('perRequestCount', 'text', array(
            'label' => Mage::helper('process')->__('Per Request Count'),
            'class' => 'required-entry',
            'name' => 'perRequestCount',
        ));

        $fieldset->addField('requestInterval', 'text', array(
            'label' => Mage::helper('process')->__('Request Interval'),
            'class' => 'required-entry',
            'name' => 'requestInterval',
        ));

        $fieldset->addField('requestModel', 'text', array(
            'label' => Mage::helper('process')->__('Request Model'),
            'class' => 'required-entry',
            'name' => 'requestModel',
        ));  
        
        $fieldset->addField('fileName', 'text', array(
            'label' => Mage::helper('process')->__('File Name'),
            'class' => 'required-entry',
            'name' => 'fileName',
        ));

        if ( Mage::getSingleton('adminhtml/session')->getProData() )
        {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getProData());
            Mage::getSingleton('adminhtml/session')->setProData(null);
        } elseif ( Mage::registry('current_process') ) {
            $form->setValues(Mage::registry('current_process')->getData());
        }
        return parent::_prepareForm();
    }

    // public function getGroupIds()
    // {
    //     $groupModel = Mage::getModel('process/group');

    // }
 }