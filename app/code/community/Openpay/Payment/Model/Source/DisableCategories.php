<?php
/**
 * Payment mode source with all categories
 *
 * @category Openpay
 * @package  Openpay_Payment
 * @author   ideatarmac.com
 */

class Openpay_Payment_Model_Source_DisableCategories 
{
    /**
     * get all Category List depend on storeid
     * 
     * @return array
     */
    function getCategoriesTreeView() 
    {
        $storeId = Mage::app()->getStore()->getStoreId();
        $categories = Mage::getModel('catalog/category')
            ->getCollection()
            ->setStoreId($storeId)
            ->addAttributeToSelect('name')
            ->addAttributeToSort('path', 'asc')
            ->addFieldToFilter('is_active', array('eq'=>'1'))
            ->load()
            ->toArray();
    
        $categoryList = array();
        foreach ($categories as $catId => $category) {
            if (isset($category['name'])) {
                $categoryList[] = array(
                    'label' => $category['name'],
                    'level'  =>$category['level'],
                    'value' => $catId
                );
            }
        }
        
        return $categoryList;
    }
 
    /**
     * Return options to system config
     * 
     * @return array
     */
    public function toOptionArray()
    {
        
        $options = array();
 
        $options[] = array(
            'label' => '-- None --',
            'value' => ''
        );       
        
        $categoriesTreeView = $this->getCategoriesTreeView();
 
        foreach($categoriesTreeView as $value) {
            $catName = $value['label'];
            $catId = $value['value'];
            $catLevel = $value['level'];
            $hyphen = '- ';
            
            for($i=1; $i<$catLevel; $i++) {
                $hyphen = $hyphen ."-  ";
            }
            
            $catName = $hyphen . $catName;
            
            $options[] = array(
               'label' => $catName,
               'value' => $catId
            );
        }
        
        return $options;
    }
}
