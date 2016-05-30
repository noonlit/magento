<?php

 require_once 'app/Mage.php';

Mage::app();


$products = Mage::getModel("evozon_catalog/banner")->getCollection();
var_dump($products);