<?php

/*
 *  @author Ilinca Dobre <>
 *  @author Haidu Bogdan <bogdan.haidu@evozon.com>
 */

class Evozon_Qa_Model_Product extends Mage_Core_Model_Abstract
{

    public function getStoreIdByProductId($id)
    {
        $product = Mage::getModel('catalog/product')->load($id);
        return $product->getStoreId();
    }

}
