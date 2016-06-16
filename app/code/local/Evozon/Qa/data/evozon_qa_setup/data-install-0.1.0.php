<?php
/**
 * 
 * @category   Evozon
 * @package    Evozon_Qa
 * @author     Delia Dumitru <delia.dumitru@evozon.com>
 * @author     Andrei Bodea <andrei.bodea@evozon.com>
 */

/**
 * Create guest user account
 */

Mage::log('Started data-install-0.1.0', NULL, 'scripts.log');

try {
    $websiteId = Mage::app()->getWebsite()->getId();
    $store = Mage::app()->getStore();
    
    $customer = Mage::getModel("customer/customer");
    $id = $customer->setWebsiteId(Mage::app()->getStore()->getWebsiteId())
                    ->loadByEmail('guestUser@madisonIsland.com')->getId();
    if (!$id) {
        $customer->setWebsiteId($websiteId)
                ->setStore($store)
                ->setFirstname('User')
                ->setLastname('Guest')
                ->setEmail('guestUser@madisonIsland.com')
                ->setPassword('password');
        $customer->save();
    }
} catch (Exception $e) {
    Mage::log($e->getMessage(), NULL, 'scripts.log');
}
Mage::log('Finished data-install-0.1.0', NULL, 'scripts.log');
