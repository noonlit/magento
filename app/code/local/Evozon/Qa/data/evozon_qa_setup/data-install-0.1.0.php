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

try {
    Mage::log('Started data-upgrade-0.1.0-0.1.1', NULL, 'scripts.log');
    $websiteId = Mage::app()->getWebsite()->getId();
    $store = Mage::app()->getStore();
    $customer = Mage::getModel("customer/customer");
    $id = $customer->setWebsiteId(Mage::app()->getStore()->getWebsiteId())
                    ->loadByEmail('guestUser@madisonIsland.com')->getId();
    if (!$id) {
        $customer->setWebsiteId($websiteId)
                ->setStore($store)
                ->setFirstname('Guest')
                ->setLastname('user')
                ->setEmail('guestUser@madisonIsland.com')
                ->setPassword('password');
        $customer->save();
    }
} catch (Exception $e) {
    Mage::log($e->getMessage(), NULL, 'scripts.log');
}