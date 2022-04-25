<?php

$installer = $this;

$installer->startSetup();

$installer->addAttribute(Hd_Mfr_Model_Resource_Mfr::ENTITY, 'name', array(
	'group' => 'General',
	'input' => 'text',
	'type' => 'varchar',
	'label' => 'name',
	'backend' => '',
	'visible' => 1,
	'required' => 0,
	'user_defined' => 1,
	'searchable' => 1,
	'filterable' => 0,
	'comparable' => 1,
	'visible_on_front' => 1,
	'visible_in_advanced_search' => 0,
	'is_html_allowed_on_front' => 1,
	
	'global' => 1,

));

$installer->addAttribute(Hd_Mfr_Model_Resource_Mfr::ENTITY, 'email', array(
	'group' => 'General',
	'input' => 'text',
	'type' => 'varchar',
	'label' => 'email',
	'backend' => '',
	'visible' => 1,
	'required' => 0,
	'user_defined' => 1,
	'searchable' => 1,
	'filterable' => 0,
	'comparable' => 1,
	'visible_on_front' => 1,
	'visible_in_advanced_search' => 0,
	'is_html_allowed_on_front' => 1,
	'global' => 1,
));

$installer->addAttribute(Hd_Mfr_Model_Resource_Mfr::ENTITY, 'mobile', array(
	'group' => 'General',
	'input' => 'text',
	'type' => 'varchar',
	'label' => 'mobile',
	'backend' => '',
	'visible' => 1,
	'required' => 0,
	'user_defined' => 1,
	'searchable' => 1,
	'filterable' => 0,
	'comparable' => 1,
	'visible_on_front' => 1,
	'visible_in_advanced_search' => 0,
	'is_html_allowed_on_front' => 1,
	'global' => 1,
));

$installer->addAttribute(Hd_Mfr_Model_Resource_Mfr::ENTITY, 'status', array(
	'group' => 'General',
	'input' => 'text',
	'type' => 'varchar',
	'label' => 'status',
	'backend' => '',
	'visible' => 1,
	'required' => 0,
	'user_defined' => 1,
	'searchable' => 1,
	'filterable' => 0,
	'comparable' => 1,
	'visible_on_front' => 1,
	'visible_in_advanced_search' => 0,
	'is_html_allowed_on_front' => 1,
	'global' => 1,
));

$installer->addAttribute(Hd_Mfr_Model_Resource_Mfr::ENTITY, 'description', array(
	'group' => 'General',
	'input' => 'text',
	'type' => 'varchar',
	'label' => 'description',
	'backend' => '',
	'visible' => 1,
	'required' => 0,
	'user_defined' => 1,
	'searchable' => 1,
	'filterable' => 0,
	'comparable' => 1,
	'visible_on_front' => 1,
	'visible_in_advanced_search' => 0,
	'is_html_allowed_on_front' => 1,
	'global' => 1,
));

$installer->endSetup();
