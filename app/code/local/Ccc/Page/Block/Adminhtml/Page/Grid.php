<?php

class Ccc_Page_Block_Adminhtml_Page_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        // echo "1111";
        // exit;
        parent::__construct();
        $this->setId('pageGrid');
        $this->setDefaultSort('type');
        $this->setDefaultDir('asc');
        $this->setSaveParametersInSession(true);

    }

    /**
     * Init page groups collection
     * @return void
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('page/page')->getCollection();

        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * Configuration of grid
     */
    protected function _prepareColumns()
    {
        $this->addColumn('page_id', array(
            'header' => Mage::helper('page')->__('ID'),
            'width' => '50px',
            'align' => 'right',
            'index' => 'page_id',
        ));

        $this->addColumn('name', array(
            'header' => Mage::helper('page')->__('Name'),
            'index' => 'name',
        ));

        $this->addColumn('code', array(
            'header' => Mage::helper('page')->__('Code'),
            'index' => 'code',
            'width' => '200px'
        ));

        $this->addColumn('value', array(
            'header' => Mage::helper('page')->__('Value'),
            'index' => 'value',
            'width' => '200px'
        ));

        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id'=>$row->getId()));
    }

}