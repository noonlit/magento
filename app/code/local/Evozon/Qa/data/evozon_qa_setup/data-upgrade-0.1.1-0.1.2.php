<?php

/**
 *
 * @category   Evozon
 * @package    Evozon_Qa
 * @author     Marius Adam <marius.adam@evozon.com>
 */

/**
 * Create new admin user
 */

Mage::log('Started data-upgrade-0.1.1-0.1.2', null, 'scripts.log');

try {
    $user = Mage::getModel('admin/user')
        ->setData(array(
            'username'  => 'admin_qa',
            'firstname' => 'Admin',
            'lastname'    => 'Admin',
            'email'     => 'mage@test.com',
            'password'  =>'password123',
            'is_active' => 1,
        ))->save();
        Mage::log('The user was added', null, 'scripts.log');
} catch (Exception $e) {
    Mage::log($e->getMessage(), null, 'scripts.log');
}

/**
 * Assign new role id
 */

try {
    $roleCollection = Mage::getModel('admin/role')
        ->getCollection()
        ->addFieldToFilter('role_name', 'Qa manager');
    $role = $roleCollection->getColumnValues('role_id');
    $user = Mage::getModel('admin/user')->load('admin_qa', 'username');
    $user
        ->setRoleIds($role)  
        ->setRoleUserId($user->getUserId())
        ->saveRelations();
    Mage::log('The role was assigned to the user', null, 'scripts.log');
} catch (Exception $e) {
    Mage::log($e->getMessage(), null, 'scripts.log');
}

Mage::log('Finished data-upgrade-0.1.1-0.1.2', null, 'scripts.log');