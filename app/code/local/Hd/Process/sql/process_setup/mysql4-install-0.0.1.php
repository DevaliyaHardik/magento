<?php

$installer = $this;
echo "111";exit;
$installer->startSetup();

$installer->run("
    -- DROP TABLE IF EXISTS {$this->getTable('group')};
    CREATE TABLE {$this->getTable('group')} (
    `group_id` int(11) unsigned NOT NULL auto_increment,
    `name` varchar(255) NOT NULL default '',
    PRIMARY KEY (`group_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

$installer->endSetup();

?>