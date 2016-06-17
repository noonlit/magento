<?php

/**
 *
 * @category   Evozon
 * @package    Evozon_Qa
 * @author     Marius Adam <marius.adam@evozon.com>
 */

/**
 * Add QA manager role
 */

Mage::log('Started data-install-0.1.0', null, 'evozon_scripts.log');

try {
    $roleName = 'Qa manager';
    $resources = array('admin/evozon_qa', 'admin/evozon_qa/questions');
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
    
    Mage::log('Done adding a user role', null, 'evozon_scripts.log');
} catch (Exception $ex) {
    Mage::log($ex->getMessage(), null, 'evozon_scripts.log');
}

Mage::log('Finished data-install-0.1.0', null, 'evozon_scripts.log');
