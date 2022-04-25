<?php
$installer = $this;
$installer->startSetup();
 
$installer->createEntityTables(
    $this->getTable('mfr/mfr_entity')
);
 
$installer->addEntityType('mfr',Array(
    'entity_model'          =>'mfr/mfr',
    'attribute_model'       =>'',
    'table'                 =>'mfr/mfr_entity',
    'increment_model'       =>'',
    'increment_per_store'   =>'0'
));
 
$installer->installEntities();
 
$installer->endSetup();