<?php
class Hd_Mfr_Block_Adminhtml_Mfr_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        // $this->setId('mfrGrid');
        // $this->setDefaultSort('entity_id');
        // $this->setDefaultDir('DESC');
        // $this->setSaveParametersInSession(true);
        // $this->setUseAjax(true);
        // $this->setVarNameFilter('mfr_filter');
    }

    protected function _getStoreId() {
      $storeId = (int) $this->getRequest()->getParam('store', 0);
      return $storeId;
    }  

    protected function _prepareCollection()
    {
      $collection = Mage::getModel('mfr/mfr')->getCollection()
          ->addAttributeToSelect('name')
          ->addAttributeToSelect('email')
          ->addAttributeToSelect('mobile')
          ->addAttributeToSelect('status')
          ->addAttributeToSelect('description')
          ->addAttributeToSelect('created_date');
      $storeId = $this->_getStoreId();
      $collection->joinAttribute(
        'name',
        'mfr/name',
        'entity_id',
        null,
        'inner',
        $storeId
      );
      $collection->joinAttribute(
        'email',
        'mfr/email',
        'entity_id',
        null,
        'inner',
        $storeId
      );
      $collection->joinAttribute(
        'mobile',
        'mfr/mobile',
        'entity_id',
        null,
        'inner',
        $storeId
      );
      $collection->joinAttribute(
        'status',
        'mfr/status',
        'entity_id',
        null,
        'inner',
        $storeId
      );
      $collection->joinAttribute(
        'description',
        'mfr/description',
        'entity_id',
        null,
        'inner',
        $storeId
      );
      $collection->joinAttribute(
        'created_date',
        'mfr/created_date',
        'entity_id',
        null,
        'inner',
        $storeId
      );
      $collection->joinAttribute(
        'id',
        'mfr/entity_id',
        'entity_id',
        null,
        'inner',
        $storeId
      );
      $this->setCollection($collection);

      parent::_prepareCollection();
      return $this;
    }

    protected function _prepareColumns()
    {
      $this->addColumn('entity_id', array(
        'header'    => Mage::helper('mfr')->__('ID'),
        'align'     =>'right',
        'width'     => '50px',
        'index'     => 'entity_id',
      ));   
      $this->addColumn('name', array(
        'header'    => Mage::helper('mfr')->__('Name'),
        'align'     =>'right',
        'width'     => '50px',
        'index'     => 'name',
      ));   

      $this->addColumn('email', array(
        'header'    => Mage::helper('mfr')->__('Email'),
        'align'     =>'right',
        'width'     => '50px',
        'index'     => 'email',
      ));

      $this->addColumn('mobile', array(
        'header'    => Mage::helper('mfr')->__('Mobile'),
        'align'     =>'right',
        'width'     => '50px',
        'index'     => 'mobile',
      ));   

      $this->addColumn('status', array(
        'header'    => Mage::helper('mfr')->__('Status'),
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
        'header'    => Mage::helper('mfr')->__('Created Date'),
        'align'     =>'right',
        'width'     => '50px',
        'index'     => 'created_date',
      ));

      $this->addColumn('description', array(
        'header'    => Mage::helper('mfr')->__('Description'),
        'align'     =>'right',
        'width'     => '50px',
        'index'     => 'description',
      )); 
      return parent::_prepareColumns();
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('mfrId');
        $this->getMassactionBlock()->setFormFieldName('mfr');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('mfr')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('mfr')->__('Are you sure?')
        ));
    }

    public function getGridUrl() {
      return $this->getUrl('*/*/index', array('_current' => true));
    }  

    public function getRowUrl($row) {
      return $this->getUrl('*/*/edit', array(
        'store' => $this->getRequest()->getParam('store'),
        'id' => $row->getId())
      );
    }
  

}

?>