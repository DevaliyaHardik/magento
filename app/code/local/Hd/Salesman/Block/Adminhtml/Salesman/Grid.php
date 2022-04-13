<?php

class Hd_Salesman_Block_Adminhtml_Salesman_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        // echo "1111";
        // exit;
        parent::__construct();
        $this->setId('salesmanGrid');
        $this->setDefaultSort('type');
        $this->setDefaultDir('asc');
        $this->setSaveParametersInSession(true);

    }

    /**
     * Init salesman groups collection
     * @return void
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('salesman/salesman')->getCollection();

        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * Configuration of grid
     */
    protected function _prepareColumns()
    {
        $this->addColumn('salesman_id', array(
            'header' => Mage::helper('salesman')->__('ID'),
            'width' => '50px',
            'align' => 'right',
            'index' => 'salesman_id',
        ));

        $this->addColumn('name', array(
            'header' => Mage::helper('salesman')->__('Name'),
            'index' => 'name',
        ));

        $this->addColumn('email', array(
            'header' => Mage::helper('salesman')->__('Email'),
            'index' => 'email',
            'width' => '200px'
        ));

        $this->addColumn('mobile', array(
            'header' => Mage::helper('salesman')->__('Mobile'),
            'index' => 'mobile',
            'width' => '200px'
        ));

        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id'=>$row->getId()));
    }

}