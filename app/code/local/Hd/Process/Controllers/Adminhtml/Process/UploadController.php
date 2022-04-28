<?php
class Hd_Process_Adminhtml_Process_UploadController extends Mage_Adminhtml_Controller_Action{

    public function indexAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('process/group');
        $this->renderLayout();
    }

    public function uploadfileAction()
    {
        $processId = $this->getRequest()->getParam('id');
		Mage::getSingleton('cms/wysiwyg_config')->setStoreId($this->getRequest()->getParam('store'));

		$process = Mage::getModel('process/process')
			->setStoreId($this->getRequest()->getParam('store', 0))
			->load($processId);

		Mage::register('current_process_media', $process);

		if (!$processId) {
			$this->_getSession()->addError(Mage::helper('process')->__('This process no longer exists'));
			$this->_redirect('*/*/');
			return;
		}
		$this->loadLayout();
		$this->renderLayout();
    }

    public function uploadAction()
    {
        $processId = $this->getRequest()->getParam('id');
        $model = Mage::getModel('process/process');
        if($model->load($processId)){
            $fileName = $model->uploadFile();
        }
        $this->_redirect('process/adminhtml_process/index');
    }

    public function verifyAction()
    {

        $processId = $this->getRequest()->getParam('id');
        $model = Mage::getModel('process/process')->load($processId);
        $model->verify();
        // $path = Mage::getBaseDir('media') . DS . 'process'; 
        // // readfile($path. DS .$model->load($processId)->getData()['fileName']);exit;
        // if (($open = fopen($path. DS .$model->load($processId)->getData()['fileName'], "r")) !== FALSE) 
        // {
        //     while (($data = fgetcsv($open, 1000, ",")) !== FALSE) 
        //     {        
        //     $array[] = $data; 
        //     }
        
        //     fclose($open);
        // }
        // $data = json_encode($array);
        // // print_r($data);exit;
        // @json_decode($data);
        // // $arrayobject = new ArrayObject($array);
        // // $iterator = $arrayobject->getIterator();
        // if(json_last_error() === JSON_ERROR_NONE){
        //     Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('CSV verify successfully'));
        // }
        // else{
        //     Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('CSV not valid'));
        // }
        $this->_redirect('process/adminhtml_process/index');
    }

    // public function exportCsvAction()
    // {
    //     $fileName = 'entries.csv';
    //     $content = $path = Mage::getBaseDir('media') . DS . 'process'. DS . 'entries.csv';

    //     $this->_prepareDownloadResponse($fileName, $content);
    //     $this->_redirect('process/adminhtml_process/index');
    // }

    public function exportCsvAction()
    {
        $fileName   = 'default.csv';
        $model = Mage::getModel('process/process')->getDefaultFile();
            $content = ['type'=>'filename','value'=>Mage::getBaseDir('media') . DS . 'process'. DS . 'import' . DS . 'default.csv','rm'=>1];
        $this->_prepareDownloadResponse($fileName, $content);
    }
}

?>