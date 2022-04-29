<?php 
$installer = $this;
$installer->startSetup();
$installer->getConnection()->addColumn($installer->getTable('process/column'), 'sampleData', "varchar(255) default NULL AFTER `name`");
$installer->endSetup();
?>