<?php
    class Hd_Process_Model_Column extends Mage_Core_Model_Abstract
    {
        CONST CASTING_INTEGER = 1;
        CONST CASTING_DESIMAL = 2;
        CONST CASTING_VARCHAR = 3;

        protected function _construct()
        {
            $this->_init('process/column');
        }
    }

?>    