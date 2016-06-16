<?php

/**
 * 
 * @category   Evozon
 * @package    Evozon_Qa
 * @author     Andra Barsoianu <andra.barsoianu@evozon.com>
 */
/**
 * Create new store view
 */
Mage::log('Started data-upgrade-0.1.2-0.1.3', null, 'scripts.log');

$store = Mage::getModel('core/store')->load('english_gb');
if (!$store->getId()) {
    $store->setCode('english_gb')
            ->setWebsiteId(1)
            ->setGroupId(1)
            ->setName('English [GB]')
            ->setIsActive(1)
            ->save();
    Mage::log('Store view added!', null, 'scripts.log');
} else {
    Mage::log('Store view already exists!', null, 'scripts.log');
}

Mage::log('Finished data-upgrade-0.1.2-0.1.3', null, 'scripts.log');
