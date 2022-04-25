<?php
class Hd_Mfr_Model_Resource_Mfr_Collection extends Mage_Catalog_Model_Resource_Collection_Abstract {
	public function __construct() {
		$this->setEntity('mfr');
		parent::__construct();
	}
}