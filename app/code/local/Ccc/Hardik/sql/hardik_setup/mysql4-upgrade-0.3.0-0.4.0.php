<?php
$installer = $this;
$installer->startSetup();
$installer->getConnection()->addColumn(
    $this->getTable('hardik'),//table name
    'status',      //column name
    'varchar(255) NOT NULL'  //datatype definition
    );

$installer->endSetup();