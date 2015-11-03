<?php
/**
 * n98-magerun.phar sys:setup:remove Twinsen_ConfigurableCustomerId
 */

$installer = $this;
$installer->startSetup();

$installer->getConnection()
    ->addColumn($installer->getTable('core/website'), 'customer_id', array(
        'type'     => Varien_Db_Ddl_Table::TYPE_TEXT,
        'nullable' => false,
        'length'   => 255,
        'comment'  => 'Customer ID'
    ));
$installer->endSetup();