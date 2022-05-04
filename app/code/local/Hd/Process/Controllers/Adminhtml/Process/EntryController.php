<?php
class Hd_Process_Adminhtml_Process_EntryController extends Mage_Adminhtml_Controller_Action{

    public function indexAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('process/entry');
        $this->renderLayout();
    }

    public function newAction()
    {
        $this->_forward('edit');
    }

	public function editAction() {

		$processId = $this->getRequest()->getParam('id');
		$process = Mage::getModel('process/entry')
			->setStoreId($this->getRequest()->getParam('store', 0))
			->load($processId);

		Mage::register('current_process_entry', $process);
		Mage::getSingleton('cms/wysiwyg_config')->setStoreId($this->getRequest()->getParam('store'));

		if ($processId && !$process->getId()) {
			$this->_getSession()->addError(Mage::helper('process')->__('This process no longer exists'));
			$this->_redirect('*/*/');
			return;
		}
		$this->loadLayout();
		$this->renderLayout();
	}

    public function saveAction() 
    {   
        // print_r($this->getRequest()->getPost('startTime'));exit;
        try
        {
            if (!$this->getRequest()->getPost()){   
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Invalid request.'));   
            }
            $id= ($this->getRequest()->getParam('id'));
            $model = Mage::getModel('process/entry')->load($id);
            $startTime = implode(':',$this->getRequest()->getPost('startTime'));
            $endTime = implode(':',$this->getRequest()->getPost('endTime'));

            $model->setData('identifier',$this->getRequest()->getPost('identifier')); 
            $model->setData('process_id',$this->getRequest()->getPost('process_id'));            
            $model->setData('startTime',$startTime);            
            $model->setData('endTime',$endTime);            
            $model->setData('data',$this->getRequest()->getPost('data'));            
           
            $model->save();
            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('process')->__('Process Entry saved successfully.'));
        }
        catch (Exception $e)
        {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }
        $this->_redirect('process/adminhtml_process_entry/index');
    }

    public function deleteAction()
    {
        if( $this->getRequest()->getParam('id') > 0 ) 
        {

            $id     = $this->getRequest()->getParam('id');
            $model2  = Mage::getModel('process/entry')->load($id);
            $model = Mage::getModel('process/entry');             
                $model->setId($this->getRequest()->getParam('id'))
                    ->delete(); //delete operation

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('successfully deleted'));
                $this->_redirect('process/adminhtml_process_entry/index');   

        }
        $this->_redirect('process/adminhtml_process_entry/index');
    }   

    public function massDeleteAction() 
    {
        $sampleIds = $this->getRequest()->getParam('entry');
        if(!is_array($sampleIds)){
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } 
        else 
        {
            try
            {
                foreach ($sampleIds as $sampleId)
                {
                    $sample = Mage::getModel('process/entry')->load($sampleId);
                    $sample->delete();

                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                Mage::helper('adminhtml')->__('Total of %d record(s) were successfully deleted', count($sampleIds)));
            } 
            catch (Exception $e)
            {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('process/adminhtml_process_entry/index');
    }
}

?>