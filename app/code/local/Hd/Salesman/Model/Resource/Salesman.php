<?php 
class Hd_Salesman_Model_Resource_Salesman extends Mage_Eav_Model_Entity_Abstract
{
    public function __construct()
    {
        $resource = Mage::getSingleton('core/resource');
        $this->setType('salesman');
        $this->setConnection(
            $resource->getConnection('salesman_read'),
            $resource->getConnection('salesman_write')
        );
    }
}
