<?php
class Ccc_Page_Model_Resource_Page extends Mage_Core_Model_Resource_Db_Abstract{

    public function _construct()
    {
        $this->_init('page/page','page_id');
    }
}

?>