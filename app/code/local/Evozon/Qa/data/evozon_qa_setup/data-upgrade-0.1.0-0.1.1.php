<?php
/**
 * Created by PhpStorm.
 * User: marius
 * Date: 6/14/16
 * Time: 10:50 AM
 */
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