<?php

class Hd_Process_Block_Adminhtml_Process_Column_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('columnGrid');
        $this->setDefaultSort('type');
        $this->setDefaultDir('asc');
        $this->setSaveParametersInSession(true);
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
     * Init category columns collection
     * @return void
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('process/column')->getCollection();

        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * Configuration of grid
     */
    protected function _prepareColumns()
    {
        $this->addColumn('column_id', array(
            'header' => Mage::helper('process')->__('ID'),
            'width' => '50px',
            'align' => 'right',
            'index' => 'column_id',
        ));

        $this->addColumn('process_id', array(
            'header' => Mage::helper('process')->__('Process Id'),
            'index' => 'process_id',
            'type' => 'options',
            'options' => $this->getProcessOption(),
        ));

        $this->addColumn('name', array(
            'header' => Mage::helper('process')->__('Name'),
            'index' => 'name',
        ));

        $this->addColumn('sampleData', array(
            'header' => Mage::helper('process')->__('Sample Data'),
            'index' => 'sampleData',
        ));

        $this->addColumn('required', array(
            'header' => Mage::helper('process')->__('Required'),
            'index' => 'required',
            'type' => 'options',
            'options' => [
                1 => 'Yes',
                0 => 'No',
            ],
        ));

        $this->addColumn('castingType', array(
            'header' => Mage::helper('process')->__('Casting Type'),
            'index' => 'castingType',
            'type' => 'options',
            'options' => [
                Hd_Process_Model_Column::CASTING_INTEGER => Mage::helper('process')->__('Integer'),
                Hd_Process_Model_Column::CASTING_DESIMAL => Mage::helper('process')->__('Desimal'),
                Hd_Process_Model_Column::CASTING_VARCHAR => Mage::helper('process')->__('Varchar'),
            ]
        ));

        $this->addColumn('exception', array(
            'header' => Mage::helper('process')->__('Exception'),
            'index' => 'exception',
        ));

        $this->addColumn('createdDate', array(
            'header' => Mage::helper('process')->__('Created Date'),
            'index' => 'createdDate',
            'type' => 'date',
        ));
        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id'=>$row->getId()));
    }

}