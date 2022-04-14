<?php

class Hd_Category_Block_Adminhtml_Category_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('categoryGrid');
        $this->setDefaultSort('type');
        $this->setDefaultDir('asc');
        $this->setSaveParametersInSession(true);

    }

    /**
     * Init category groups collection
     * @return void
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('category/category')->getCollection();

        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * Configuration of grid
     */
    protected function _prepareColumns()
    {
        $this->addColumn('category_id', array(
            'header' => Mage::helper('category')->__('ID'),
            'width' => '50px',
            'align' => 'right',
            'index' => 'category_id',
        ));

        $this->addColumn('name', array(
            'header' => Mage::helper('category')->__('Name'),
            'index' => 'name',
        ));

        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id'=>$row->getId()));
    }

}