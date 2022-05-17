<?php 
class Hd_Process_Model_Vendor extends Hd_Process_Model_Process_Abstract
{
	protected $type = ['integer','decimal','varchar','text'];
	public function getIdentifier($row)
	{
		return $row['name'];
	}
	
	public function prepareRow($row)	
	{
		return[
			'name' => $row['name'],
			'group' => $row['group'],
			'attribute_set' => $row['attribute_set'],
			'type' => $row['type'],
			'input' => $row['input'],
			'lable' => $row['lable'],
			'source' => $row['source'],
			'required' => $row['required']
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
			$attributeData = json_decode($entry['data'], true);
			$array = [
					'group' => $attributeData['group'],
					'attribute_set' => $attributeData['attribute_set'],
					'type' => $attributeData['type'],
					'lable'=> $attributeData['lable'],
					'input' => $attributeData['input'],
					'source' => $attributeData['source'],
					'required' => $attributeData['required'],
				];
				Mage::log($attributeData,null,'Hardik.log',True);
			$installer->addAttribute('vendor', $attributeData['name'],$array);
		}
		$installer->endSetup();
		return true;
	}
}