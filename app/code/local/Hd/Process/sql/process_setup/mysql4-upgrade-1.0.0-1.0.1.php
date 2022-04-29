<?php 
$installer = $this;
$installer->startSetup();

$installer->run("
	-- DROP TABLE IF EXISTS {$this->getTable('process')};
	CREATE TABLE {$this->getTable('process')} (
	`process_id` int(11) NOT NULL auto_increment,
	`group_id` int(11) NOT NULL,
	`name` varchar(64) NOT NULL ,
	`type_id` tinyint NOT NULL ,
	`perRequestCount` varchar(64) NOT NULL ,
	`requestInterval` varchar(64) NOT NULL ,
	`requestModel` varchar(64) NOT NULL ,
	`fileName` varchar(64) NOT NULL ,
	`createdDate` datetime  ,
	PRIMARY KEY (`process_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");

$installer->run("
    ALTER TABLE {$this->getTable('process')}
    ADD CONSTRAINT  FOREIGN KEY (`group_id`)
    REFERENCES `{$this->getTable('process_group')}` (`group_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE;
    ");

$installer->endSetup();