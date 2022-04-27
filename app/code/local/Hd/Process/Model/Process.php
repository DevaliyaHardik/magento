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

        public function uploadFile($processId)
        {
            $model = Mage::getModel('process/process');
            $model->load($processId);
            $fileData = $_FILES['fileName'];
            $fileName = $fileData['name'];
            $fileSize = $fileData['size'];
            $fileTmp = $fileData['tmp_name'];
            $fileType = $fileData['type'];
            $ext = explode('.',$fileName);
            $fileExt = end($ext);
            $fileName = prev($ext)."".date('dmYhis').".".$fileExt;
            
            if(isset($fileName) && $fileName != '')
            {
                $path = Mage::getBaseDir('media') . DS . 'process'; 
                if($model->getData()['fileName']){
                    unlink($path. DS . $model->getData()['fileName']);
                }
                move_uploaded_file($fileTmp,$path . DS . $fileName);
            }
            return $fileName;    
        }
    }

?>    