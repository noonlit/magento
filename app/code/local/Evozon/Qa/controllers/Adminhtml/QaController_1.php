<?php

class Evozon_Qa_Adminhtml_QaController extends Mage_Adminhtml_Controller_Action
{

//    public function indexAction()
//    {
//        $this->loadLayout();
//        $this->_setActiveMenu('qa')
//              ->_title('Q & A Management');
//        //create a text block with the name of "example-block"
//        $block = $this->getLayout()
//                ->createBlock('core/text', 'example-block')
//                ->setText('<h1>This is a text block</h1>');
//
//        $this->_addContent($block);
//        //var_dump($this->getLayout()->createBlock('evozon_qa_adminhtml/content'));
////        $block2 = $this->getLayout()
////                ->createBlock('evozon_qa_adminhtml/menu')
////                ->setText('<h1>This is a text block</h1>');
////
////        $this->_addContent($block2);
//
//        $this->_addBreadcrumb($this->__('Q A Management'), $this->__('Q A Management'));
//        $this->renderLayout();
//    }

    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('qa');
    }

    protected function _initAction()
    {
        $this->loadLayout()
                ->_setActiveMenu('qa/menu')
                ->_addBreadcrumb($this->__('Menu Items Manager'), $this->__('Menu Item Manager'));
        $this->_title($this->__('Custom Menu'));
        
        return $this;
    }

    /**
     * show grid
     *
     * @return void
     */
    public function indexAction()
    {
        $this->_initAction()
                ->renderLayout();
    }

    /**
     * edit menu item action
     *
     * @return void
     */
    public function editAction()
    {
        $menuId = intval($this->getRequest()->getParam('id', 0));
        $error = false;
        if ($menuId) {
            $model = Mage::getModel('menu/menu')->load($menuId);
            if ($model->getId()) {
                $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
                if ($data) {
                    $model->setData($data)->setId($menuId);
                }
                Mage::register('current_menu', $model);
            } else {
                $this->_getSession()->addError($this->__('Menu Item doesn\'t exist'));
                $error = true;
            }
        }
        if ($error) {
            $this->_redirectError($this->_getRefererUrl());
        } else {
            $this->_initAction();
            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
            $this->renderLayout();
        }
    }

    /**
     * new menu item action
     *
     * @return void
     */
    public function newAction()
    {
        $this->_forward('edit');
    }

    /**
     * save menu item action
     *
     * @return void
     */
    public function saveAction()
    {
        $error = false;
        if ($data = $this->getRequest()->getPost()) {
            $data['show_children'] = isset($data['show_children']);
            $model = Mage::getModel('menu/menu');
            $menuId = intval($this->getRequest()->getParam('id', 0));
            if ($menuId) {
                $model->load($menuId);
            }
            $this->_getSession()->setFormData($data);
            try {
                $model->setData($data);
                if ($menuId) {
                    $model->setId($menuId);
                }
                $model->save();
                if (!$model->getId()) {
                    Mage::throwException($this->__('Error saving menu item'));
                }
                $this->_getSession()->addSuccess($this->__('Menu Item was successfully saved.'));
                Mage::app()->getCacheInstance()->invalidateType(Mage_Core_Block_Abstract::CACHE_GROUP);
                $this->_getSession()->setFormData(false);
            } catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
                $error = true;
            } catch (Exception $e) {
                $this->_getSession()->addError($this->__('Error while saving menu item'));
                Mage::logException($e);
                $error = true;
            }
        } else {
            $this->_getSession()->addError($this->__('No data found to save'));
        }
        if (!$error && isset($model) && $model->getId()) {
            // The following line decides if it is a "save" or "save and continue"
            if ($this->getRequest()->getParam('back')) {
                $this->_redirect('*/*/edit', array('id' => $model->getId()));
            } else {
                $this->_redirect('*/*/');
            }
        } else {
            $this->_redirectReferer();
        }
    }

    /**
     * delete menu item action
     *
     * @return mixed
     */
    public function deleteAction()
    {
        if ($menuId = $this->getRequest()->getParam('id')) {
            try {
                $model = Mage::getModel('menu/menu');
                $model->setId($menuId);
                $model->delete();
                $this->_getSession()->addSuccess($this->__('Menu Item has been deleted.'));
                Mage::app()->getCacheInstance()->invalidateType(Mage_Core_Block_Abstract::CACHE_GROUP);
                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        $this->_getSession()->addError($this->__('Unable to find the menu item to delete.'));
        $this->_redirect('*/*/');
    }

    /**
     * load grid for ajax action
     *
     * @return void
     */
    public function gridAction()
    {
        $this->loadLayout()
                ->renderLayout();
    }

    /**
     * mass delete menu items action
     *
     * @return void
     */
    public function massDeleteAction()
    {
        $menuIds = $this->getRequest()->getParam('menu');
        if (!is_array($menuIds)) {
            $this->_getSession()->addError($this->__('Please select menu item(s).'));
        } else {
            try {
                foreach ($menuIds as $menuId) {
                    Mage::getSingleton('menu/menu')
                            ->load($menuId)
                            ->delete();
                }
                $this->_getSession()->addSuccess(
                        $this->__(
                                'Total of %d record(s) were deleted.', count($menuIds)
                        )
                );
                Mage::app()->getCacheInstance()->invalidateType(Mage_Core_Block_Abstract::CACHE_GROUP);
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/');
    }

}
