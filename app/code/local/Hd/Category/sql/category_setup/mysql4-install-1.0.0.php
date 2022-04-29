<?php

    $installer = $this;

    $installer->startSetup();
    $installer->run("

    -- DROP TABLE IF EXISTS {$this->getTable('category')};
    CREATE TABLE {$this->getTable('category')} (
      `category_id` int(11) unsigned NOT NULL auto_increment,
      `name` varchar(255) NOT NULL default '',
      PRIMARY KEY (`category_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");



    $installer->endSetup();


?>