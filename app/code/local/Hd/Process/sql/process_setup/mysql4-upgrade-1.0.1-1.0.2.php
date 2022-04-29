<?php 
$installer = $this;
$installer->startSetup();

$installer->run("
	-- DROP TABLE IF EXISTS {$this->getTable('process_column')};
	CREATE TABLE {$this->getTable('process_column')} (
	`column_id` int(11) NOT NULL auto_increment,
	`process_id` int(11) NOT NULL,
	`name` varchar(64) NOT NULL ,
	`required` int NOT NULL ,
	`castingType` int NOT NULL ,
	`exception` int NOT NULL ,
	`createdDate` datetime  ,
	PRIMARY KEY (`column_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");

$installer->run("
    ALTER TABLE {$this->getTable('process_column')}
    ADD CONSTRAINT  FOREIGN KEY (`process_id`)
    REFERENCES `{$this->getTable('process')}` (`process_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE;
    ");

$installer->endSetup();