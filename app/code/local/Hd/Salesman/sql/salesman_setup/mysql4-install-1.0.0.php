<?php
$installer = $this;
$installer->startSetup();
 
$installer->createEntityTables(
    $this->getTable('salesman/salesman_entity')
);

$installer->addEntityType('salesman',Array(
    'entity_model'          =>'salesman/salesman',
    'attribute_model'       =>'',
    'table'                 =>'salesman/salesman_entity',
    'increment_model'       =>'',
    'increment_per_store'   =>'0'
));
 
$installer->installEntities();
 
$installer->endSetup();
