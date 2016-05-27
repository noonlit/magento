<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'app/Mage.php';

Mage::app();

$object = Mage::app()->getLayout()->createBlock('catalog/product_list');

//var_dump($object);
$object->sayHello();
//$product = new Evozon_Bogdan_Catalog_Model_Product ();
$product = Mage::getModel("catalog/category");
//var_dump($product);
$product->sayHello();
