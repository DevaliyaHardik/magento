<?php 
class Hd_Process_Model_Option extends Hd_Process_Model_Process_Abstract
{
	//protected $type = ['int','decimal','varchar','text'];
	public function getIdentifier($row)
	{
		return $row['option'];
	}
	
	public function prepareRow($row)	
	{
		return[
			'attribute_code' => $row['attribute_code'],
			'option_order' => $row['option_order'],
			'option' => $row['option'],
		];
	}

	public function validateRow(&$row)
	{
		return $row;
	}

	public function import($entryData)	
	{

		$installer = new Hd_Vendor_Model_Resource_Setup('core_setup');
		$installer->startSetup();
		foreach ($entryData as $key => $entry) 
		{
			$optionData = json_decode($entry['data'], true);
			$attributeCode = $optionData['attribute_code'];
			$attribute = Mage::getModel('eav/entity_attribute')->loadByCode('vendor', $attributeCode);

			 if($attribute->getId() && $attribute->getFrontendInput()=='select') {
			    $newOptions = array('attribute_id' => $attribute->getId(),'values' => array($optionData['option_order']=>$optionData['option']));       
			    $installer->addAttributeOption($newOptions);
			}
		}
		return true;
	}
}