<?php
/**
 * Created by PhpStorm.
 * User: marius
 * Date: 6/14/16
 * Time: 11:32 AM
 */
Mage::log('Started adding a user and assign the Qa role', null, 'scripts.log');
//Create New admin User programmatically.
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
} catch (Exception $e) {
    Mage::log($e->getMessage(), null, 'scripts.log');
    return;
}
//Assign Role Id
try {
    $roleCollection = Mage::getModel('admin/role')
        ->getCollection()
        ->addFieldToFilter('role_name', 'Qa manager');
    $role = $roleCollection->getColumnValues('role_id');
    $user
        ->setRoleIds($role)  //Administrator role id is 1 ,Here you can assign other roles ids
        ->setRoleUserId($user->getUserId())
        ->saveRelations();
    Mage::log('The user was added and asigned the role', null, 'scripts.log');
} catch (Exception $e) {
    Mage::log($e->getMessage(), null, 'scripts.log');
}