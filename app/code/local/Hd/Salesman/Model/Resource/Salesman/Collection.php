<?php

class Hd_Salesman_Model_Resource_Salesman_Collection extends Mage_Eav_Model_Entity_Collection_Abstract
{   
    protected function _construct()
    {      
        $this->_init('salesman/salesman');
    }
}
