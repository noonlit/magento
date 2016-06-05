<?php

class Evozon_Bogdan_Catalog_Helper_Categories extends Mage_Core_Helper_Abstract
{

    public function getCategoriestId($rootCategory, $attriubetSetName)
    {
        $sortedCategories = array();
        $categories = Mage::getResourceModel('catalog/category_collection')
                ->addFieldToFilter('name', $rootCategory)
                ->getFirstItem() // The parent category
                ->getChildrenCategories()
                ->addFieldToFilter('name', $attriubetSetName)
                ->getItems();

        foreach ($categories as $category)
        {
            $sortedCategories[] = (int)$category->getId();
        }
        return $sortedCategories;
    }

}
