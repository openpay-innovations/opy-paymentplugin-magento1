<?php
$installer = $this;
$installer->startSetup();
$installer->run("
ALTER TABLE `{$installer->getTable('sales/order')}` 
ADD `token` VARCHAR( 255 ) NOT NULL;
");
$installer->endSetup();

