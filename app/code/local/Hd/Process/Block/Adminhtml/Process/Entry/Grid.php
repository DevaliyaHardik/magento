<?php

class Hd_Process_Block_Adminhtml_Process_Entry_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('entryGrid');
        $this->setDefaultSort('type');
        $this->setDefaultDir('asc');
        $this->setSaveParametersInSession(true);
    }

    /**
     * Init category entrys collection
     * @return void
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('process/entry')->getCollection();

        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function getProcessOption()
    {
        $model = Mage::getModel('process/process');
        $select = $model->getCollection()
                ->getSelect()
                ->reset(Zend_Db_Select::COLUMNS)
                ->columns(['process_id'])
                ->order('process_id DESC');
        $option = $model->getResource()->getReadConnection()->fetchAll($select);
        $index = 0;
        $processOption = [];
        foreach($option as $key => $value){
            $option = [$index => $value['process_id']];
            $index++;
            $processOption = array_merge($option,$processOption);
        }
        return $processOption;
    }

    /**
     * Configuration of grid
     */
    protected function _prepareColumns()
    {
        $this->addColumn('entity_id', array(
            'header'    => Mage::helper('process')->__('ID'),
            'align'     =>'right',
            'width'     => '50px',
            'index'     => 'entity_id',
          ));   
  
        $this->addColumn('entry_id', array(
            'header' => Mage::helper('process')->__('ID'),
            'width' => '50px',
            'align' => 'right',
            'index' => 'entry_id',
        ));

        $this->addColumn('process_id', array(
            'header' => Mage::helper('process')->__('Process Id'),
            'index' => 'process_id',
            'type' => 'options',
            'options' => $this->getProcessOption(),
        ));

        $this->addColumn('identifier', array(
            'header' => Mage::helper('process')->__('Identifier'),
            'index' => 'identifier',
        ));

        $this->addColumn('startTime', array(
            'header' => Mage::helper('process')->__('Start Time'),
            'index' => 'startTime',
            'type' => 'time',
        ));

        $this->addColumn('endTime', array(
            'header' => Mage::helper('process')->__('End Time'),
            'index' => 'endTime',
            'type' => 'time',
        ));

        $this->addColumn('data', array(
            'header' => Mage::helper('process')->__('Data'),
            'index' => 'data',
        ));

        $this->addColumn('createdDate', array(
            'header' => Mage::helper('process')->__('Created Date'),
            'index' => 'createdDate',
            'type' => 'date',
        ));
        return parent::_prepareColumns();
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entry_id');
        $this->getMassactionBlock()->setFormFieldName('entry');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('process')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('process')->__('Are you sure?')
        ));
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id'=>$row->getId()));
    }

}