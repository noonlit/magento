<?php

Mage::log('Started data-upgrade-0.1.4', null, 'scripts.log');

// add bundle product - a spellbook

$date = new DateTime();

Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);

