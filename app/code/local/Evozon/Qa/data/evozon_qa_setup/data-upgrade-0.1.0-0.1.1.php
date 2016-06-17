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
Mage::log('Started data-upgrade-0.1.0-0.1.1', null, 'evozon_scripts.log');

try {
    $store = Mage::getModel('core/store')->load('english_gb');
    if (!$store->getId()) {
        $store->setCode('english_gb')
                ->setWebsiteId(1)
                ->setGroupId(1)
                ->setName('English [GB]')
                ->setIsActive(1)
                ->save();
        
        Mage::log('Store view added', null, 'evozon_scripts.log');
    } else {
        Mage::log('Store view already exists', null, 'evozon_scripts.log');
    }
} catch (Exception $ex) {
    Mage::log($ex->getMessage(), null, 'evozon_scripts.log');
}
Mage::log('Finished data-upgrade-0.1.0-0.1.1', null, 'evozon_scripts.log');
