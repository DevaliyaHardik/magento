<?php
class Hd_Mfr_Model_Resource_Mfr extends Mage_Eav_Model_Entity_Abstract {
	const ENTITY = 'mfr';

	public function __construct() {
		$this->setType(self::ENTITY)
			->setConnection('core_read', 'core_write');
		parent::__construct();
	}
}