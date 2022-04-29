<?php
    class Hd_Process_Model_Process extends Mage_Core_Model_Abstract
    {
        CONST TYPE_IMPORT = 1;
        CONST TYPE_EXPORT = 2;
        CONST TYPE_CORN = 3;

        protected function _construct()
        {
            $this->_init('process/process');
        }
    }
?>    