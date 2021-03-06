<?php

class Hd_Salesman_Block_Adminhtml_Salesman_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('salesmanGrid');
        $this->setDefaultSort('type');
        $this->setDefaultDir('asc');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection()
    {
      $collection = Mage::getModel('vendor/vendor')->getCollection()
          ->addAttributeToSelect('first_name')
          ->addAttributeToSelect('last_name')
          ->addAttributeToSelect('email')
          ->addAttributeToSelect('mobile')
          ->addAttributeToSelect('status')
          ->addAttributeToSelect('created_date')
          ->addAttributeToSelect('updated_date');
      $this->setCollection($collection);
      return parent::_prepareCollection();
    }

    // protected function _prepareCollection()
    // {
    //     $collection = Mage::getModel('category/category')->getCollection();

    //     $this->setCollection($collection);
    //     return parent::_prepareCollection();
    // }

    protected function _prepareColumns()
    {
        $this->addColumn('entity_id', array(
          'header'    => Mage::helper('salesman')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'entity_id',
        ));   

        $this->addColumn('first_name', array(
          'header'    => Mage::helper('salesman')->__('First Name'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'first_name',
        ));   

        $this->addColumn('last_name', array(
          'header'    => Mage::helper('salesman')->__('Last Name'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'last_name',
        ));

        $this->addColumn('email', array(
          'header'    => Mage::helper('salesman')->__('Email'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'email',
        ));

        $this->addColumn('mobile', array(
          'header'    => Mage::helper('salesman')->__('Mobile'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'mobile',
        ));   

        $this->addColumn('status', array(
          'header'    => Mage::helper('salesman')->__('Status'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'status',
          'type'      => 'options',
          'options'    => array(
                        1 => 'Enable',
                        2 => 'Disable'
                    ),
        ));    

        $this->addColumn('created_date', array(
          'header'    => Mage::helper('salesman')->__('Created Date'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'created_date',
        ));

        $this->addColumn('updated_date', array(
          'header'    => Mage::helper('salesman')->__('Updated Date'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'updated_date',
        )); 

        return parent::_prepareColumns();
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('salesmanId');
        $this->getMassactionBlock()->setFormFieldName('salesman');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('salesman')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('salesman')->__('Are you sure?')
        ));
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id'=>$row->getId()));
    }

}
