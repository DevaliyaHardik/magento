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
        $process = Mage::getModel('process/process');
        if($process->load($processId)){
            $model = Mage::getModel($process->getData()['requestModel']);
            $fileName = $model->setProcess($process)->uploadFile();
        }
        $this->_redirect('process/adminhtml_process/index');
    }

    public function verifyAction()
    {
        try{
            $processId = $this->getRequest()->getParam('id');
            $process = Mage::getModel('process/process');
            if($process->load($processId)){
                $model = Mage::getModel($process->getData()['requestModel']);
                $fileName = $model->setProcess($process)->verify();
            }
            Mage::getSingleton('adminhtml/session')->addSuccess('Data verified successfully.');
        }catch(Exception $e){
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }
        $this->_redirect('process/adminhtml_process/index');

    }


    public function exportCsvAction()
    {
        $model = Mage::getModel('process/process')
                ->load($this->getRequest()->getParam('id'))
                ->getDefaultFile();
        $fileName   = 'sample.csv';
        $content = ['type'=>'filename','value'=>Mage::getBaseDir('media') . DS . 'process'. DS . 'import' . DS . 'sample.csv','rm'=>1];
        $this->_prepareDownloadResponse($fileName, $content);

        $this->_redirect('process/adminhtml_process/index');
    }
}

?>