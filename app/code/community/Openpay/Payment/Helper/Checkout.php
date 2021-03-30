<?php
/**
 * Helper class for Checkout process
 *
 * @category Openpay
 * @package  Openpay_Payment
 * @author   ideatarmac.com
 */

class Openpay_Payment_Helper_Checkout extends Mage_Core_Helper_Abstract  
{
    /**
     * create an Invoice for this order
     * 
     * @param Mage_Sales_Model_Order $order
     */
    public function generateInvoice($order)
    {
        try {
            if(!$order->canInvoice()) {
                Mage::throwException(Mage::helper('core')->__('Cannot create an invoice.'));
            }
            //capture the payment
            $invoice = Mage::getModel('sales/service_order', $order)->prepareInvoice();
            $invoice->setRequestedCaptureCase(Mage_Sales_Model_Order_Invoice::CAPTURE_ONLINE);
            $invoice->register();
            
            $transaction = Mage::getModel('core/resource_transaction')
            ->addObject($invoice)
            ->addObject($invoice->getOrder());

            $transaction->save();
        } catch (Mage_Core_Exception $e) {
            Mage::Log($e->getMessage());
        }
    }
    
    /**
     * get all products which are in cart
     * 
     * @param Mage_Sales_Model_Quote $quote
     * @return array
     */
    private function getProductSkus($quote) 
    {
        $skus = [];
        $cartItems = $quote->getAllVisibleItems();
        foreach ($cartItems as $item) {
            $skus[] = $item->getSku();
        }

        return $skus;
    }
    
    /**
     * get all categories from products which are in cart
     * 
     * @param Mage_Sales_Model_Quote $quote
     * @return array
     */
    private function getCategoriesOfProducts($quote) 
    {
        $categories = [];
        $cartItems = $quote->getAllItems();
        foreach ($cartItems as $item) {
            $type = $item->getProduct()->getTypeId();
            if ($type == 'simple') {
                $categoryCollection = $item->getProduct()->getCategoryCollection();
                foreach ($categoryCollection as $category) {
                    $path = explode('/',$category->getPath());
                    $categories[] = $path;
                }
            }   
        }
        $allCatIds = [];
        if (count($categories) > 0) {
            foreach ($categories as $ids) {
                foreach ($ids as $id) {
                    $allCatIds[] = $id;
                }
            }
        }
        
        return $allCatIds;
    }
    
    /**
     * check if there are some products can't be payed with openpay
     * 
     * @param Mage_Sales_Model_Quote $quote
     * @return boolean
     */
    public function isProductExcluded($quote)
    {       
        $excludedProducts = $this->_getHelper()->getDisabledProducts();
        if (!empty($excludedProducts)) {
            $excludedProductsArray = explode(",", $excludedProducts);
            $productInQuote = $this->getProductSkus($quote);
            
            return !empty(array_intersect($productInQuote, $excludedProductsArray));
        }
        
        return false;
    }
    
    /**
     * check if there are some products can't be payed with openpay
     * 
     * @param Mage_Sales_Model_Quote $quote
     * @return boolean
     */
    public function isCategoryExcluded($quote)
    {
        $excludedCategories = $this->_getHelper()->getDisabledCategories();
        if (!empty($excludedCategories)) {
            $catIds = explode(',', $excludedCategories);
            $categoryInQuote = $this->getCategoriesOfProducts($quote);
            
            return !empty(array_intersect($categoryInQuote, $catIds));
        }

        return false;
    }
    
    /**
     * Retrieve Openpay helper
     *
     * @return Openpay_Payment_Helper_Data
     */
    protected function _getHelper()
    {
        return Mage::helper('openpay_payment');
    }
}
