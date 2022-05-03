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

    public function executeAction()
    {
        $this->loadLayout();
        $processId = $this->getRequest()->getParam('id');
        $process = Mage::getModel('process/process')->load($processId);
        $entry = Mage::getModel('process/entry');
        $select = $entry->getCollection()
                ->getSelect()
                ->reset(Zend_Db_Select::COLUMNS)
                ->columns(['data'])
                ->where('process_id = ?', $processId);
        $entryData = $entry->getResource()->getReadConnection()->fetchAll($select);
        $totalCount = count($entryData);
        $perRequestCount = $process->getData()['perRequestCount'];
        $totalRequest = $totalCount/$perRequestCount;
        $currentRequest = 0;
        Mage::getSingleton('core/session')->setMyVariable(['processId' => $processId,'totalCount' => $totalCount,'perRequestCount' => $perRequestCount,'totalRequest' => $totalRequest,'currentRequest' => $currentRequest]);
        $this->renderLayout();
    }
    
    public function processEntryAction()
    {
        try {
            $session = Mage::getSingleton('core/session')->getMyVariable();
            $processId = $session['processId'];
            $totalCount = $session['totalCount'];
            $perRequestCount = $session['perRequestCount'];
            $totalRequest = $session['totalCount'];
            $currentRequest = $session['currentRequest'];

            $process = Mage::getModel('process/process')->load($processId);
            $entry = Mage::getModel('process/entry');
            $select = $entry->getCollection()
                ->getSelect()
                ->reset(Zend_Db_Select::COLUMNS)
                ->columns(['data'])
                ->where('process_id = ?', $processId)
                ->limit($perRequestCount,$currentRequest);
            $data = $entry->getResource()->getReadConnection()->fetchAll($select);
            foreach ($data as $key => $row) {
                $data[$key] = json_decode($row['data']);
            }
            foreach ($data as $key => $row) {
                $model = Mage::getModel($process->getData()['requestModel']);
                $model->setData('name',$row->name);
                $model->setData('description',$row->description);
                $model->setData('link',$row->link);
                $model->setData('is_fetured',$row->is_fetured);
                $model->setData('sort_order',$row->sort_order);
                $model->save();
            }
            if($totalCount > $perRequestCount*($currentRequest)){
                Mage::getSingleton('core/session')->setMyVariable(['processId' => $processId,'totalCount' => $totalCount,'perRequestCount' => $perRequestCount,'totalRequest' => $totalRequest,'currentRequest' => $currentRequest+1]);
                echo "Complete ". $perRequestCount*$currentRequest ." out of ". $totalCount;
                // $message = json_encode([
                //     'redirect' => true,
                //     'message' => "Complete ". $perRequestCount*$currentRequest ." out of ". $totalCount
                // ]);
            }
            else{
                // echo false;
                echo get_class($this->_redirect('process/adminhtml_process/index'));
                // $message = json_encode([
                //     'redirect' => false,
                //     'message' => $this->_redirect('process/adminhtml_process/index'),
                // ]);
            }
            // print_r($message);;
            
        } catch (Exception $e) {
        
        }
    }

    public function exportCsvAction()
    {
        $process = Mage::getModel('process/process')->load($this->getRequest()->getParam('id'));
        $model = Mage::getModel('process/process_abstract')->setProcess($process)->getSampleFile();
        $fileName   = 'sample.csv';
        $content = ['type'=>'filename','value'=>Mage::getBaseDir('media') . DS . 'process'. DS . 'import' . DS . 'sample.csv','rm'=>1];
        $this->_prepareDownloadResponse($fileName, $content);

        $this->_redirect('process/adminhtml_process/index');
    }
}

?>