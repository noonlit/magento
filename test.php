<?php
//FIND ATTRIBUTES NAMES

require_once 'app/Mage.php';

Mage::app();

$attributeSetModel = Mage::getModel("eav/entity_attribute_set");

for ($i = 0; $i < 15; $i++) {
    if (!empty($attributeSetModel->load($i))) {
        echo "attribute_id $i " . $attributeSetModel->load($i)->getAttributeSetName() . " <br>";
    }
}