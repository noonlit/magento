<?php

class Evozon_QA_Model_Menu extends Mage_Core_Model_Abstract
{

    /**
     * Initialize resources
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('menu/menu');
    }

    /**
     * Get default category id
     *?? KEEP OR DELETE ??
     * @return int
     */
    public function getDefaultCategoryId()
    {
        $category = Mage::app()->getStore()->getRootCategoryId();
        if ($this->getDefaultCategory()) {
            $category = intval($this->getDefaultCategory());
        }
        return $category;
    }

    /**
     * KEEP OR DELETE ??
     * @return Mage_Catalog_Model_Category
     */
    public function getCategory()
    {
        if (!$this->hasData('category_object')) {
            $category = Mage::getModel('catalog/category');
            if ($this->getDefaultCategory()) {
                $category->load($this->getDefaultCategory());
            }
            $this->setData('category_object', $category);
        }
        return $this->getData('category_object');
    }

}
