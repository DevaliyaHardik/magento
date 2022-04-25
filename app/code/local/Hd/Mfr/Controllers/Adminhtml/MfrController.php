<?php

class Hd_Mfr_Adminhtml_MfrController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->_title($this->__('Mfr'))->_title($this->__('Mfr Info'));
        $this->loadLayout();
        $this->_setActiveMenu('mfr/group');
        $this->renderLayout();
    }

    public function newAction()
    {
        $this->_forward('edit');
    }

	public function editAction() {

		$mfrId = $this->getRequest()->getParam('id');
		$mfr = Mage::getModel('mfr/mfr')
			->setStoreId($this->getRequest()->getParam('store', 0))
			->load($mfrId);

		Mage::register('current_mfr', $mfr);
		Mage::getSingleton('cms/wysiwyg_config')->setStoreId($this->getRequest()->getParam('store'));

		if ($mfrId && !$mfr->getId()) {
			$this->_getSession()->addError(Mage::helper('mfr')->__('This mfr no longer exists'));
			$this->_redirect('*/*/');
			return;
		}
		$this->loadLayout();
		$this->renderLayout();
	}

    public function deleteAction()
    {
        if( $this->getRequest()->getParam('id') > 0 ) 
        {

            $id     = $this->getRequest()->getParam('id');
            $model2  = Mage::getModel('mfr/mfr')->load($id);
            $model = Mage::getModel('mfr/mfr');             
                $model->setId($this->getRequest()->getParam('id'))
                    ->delete(); //delete operation

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('successfully deleted'));
                $this->_redirect('mfr/adminhtml_mfr/grid');   

        }
        $this->_redirect('mfr/adminhtml_mfr/index');
    }   

    public function saveAction() 
    {   
        try
        {
            if (!$this->getRequest()->getPost())
            {   
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Invalid request.'));   
            }
                
            $id= ($this->getRequest()->getParam('id'));
            $model = Mage::getModel('mfr/mfr')->load($id);
            $model->setData('entity_id',$id);

            $model->setData('name',$this->getRequest()->getPost('name'));
            $model->setData('email',$this->getRequest()->getPost('email'));
            $model->setData('mobile',$this->getRequest()->getPost('mobile'));
            $model->setData('description',$this->getRequest()->getPost('description'));
            $model->setData('status',$this->getRequest()->getPost('status'));
            if(!$id){
                $model->setData('created_date', Mage::getModel('core/date')->date('Y-m-d H:i:s'));
            }
            
            $model->save();
            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('mfr')->__('Mfr saved successfully.'));
        }
        catch (Exception $e)
        {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }
        $this->_redirect('mfr/adminhtml_mfr/index');
    }

    public function massDeleteAction() 
    {
        $sampleIds = $this->getRequest()->getParam('mfr');
        if(!is_array($sampleIds))
        {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } 
        else 
        {
            try
            {
                foreach ($sampleIds as $sampleId)
                {
                    $sample = Mage::getModel('mfr/mfr')->load($sampleId);
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
        $this->_redirect('mfr/adminhtml_mfr/index');
    }

}

?>