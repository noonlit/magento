<?php

//add new role
Mage::log('Started adding a user role(Qa manager)', null, 'scripts.log');
try {
    $roleName = 'Qa manager';
    $resources = array('admin/evozon_qa', 'admin/evozon_qa/questions', 'admin/evozon_qa/answers');
    $model = Mage::getModel('admin/role')
        ->setRoleName($roleName)
        ->setRoleType('G')
        ->setTreeLevel(1)
        ->save();
    $rules = Mage::getModel('admin/rules')
        ->setRoleId($model->getRoleId())
        ->setResources($resources);
    $rules = Mage::getModel('admin/resource_rules')
        ->saveRel($rules);
    Mage::log('the role was added', null, 'scripts.log');
    Mage::log('Done adding a user role', null, 'scripts.log');
}catch(Exception $ex) {
    Mage::log($ex->getMessage(), null, 'scripts.log');
}

//add guest user account
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