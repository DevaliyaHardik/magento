<?php
class Hd_Process_Model_Resource_Process_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{   
    protected function _construct()
    {      
        $this->_init('process/process');
    }

}

?>