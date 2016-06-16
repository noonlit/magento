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

Mage::log('Started data-upgrade-0.1.0-0.1.1', null, 'scripts.log');

try {
    $roleName = 'Qa manager';
    $resources = array('admin/evozon_qa', 'admin/evozon_qa/questions', 'admin/evozon_qa/answers');
    $role = Mage::getModel('admin/role')->load($roleName, 'role_name');
    if(!$role->getId()) {
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

        Mage::log('Done adding a user role', null, 'scripts.log');
    } else {
        Mage::log('Role already added', null, 'scripts.log');
    }
} catch (Exception $ex) {
    Mage::log($ex->getMessage(), null, 'scripts.log');
}

Mage::log('Finished data-upgrade-0.1.0-0.1.1', null, 'scripts.log');