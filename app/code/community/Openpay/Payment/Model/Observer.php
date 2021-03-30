<?php
/**
 * Openpay Observer where you can extend Magento events
 *
 * @category Openpay
 * @package  Openpay_Payment
 * @author   ideatarmac.com
 */

class Openpay_Payment_Model_Observer 
{
    protected $_code = 'openpay';
    
    /**
     * disable Openpay depend on total price or categories/products
     * 
     * @param Varien_Event_Observer $observer
     */
    public function paymentMethodIsActive(Varien_Event_Observer $observer)
    {
        $method = $observer->getMethodInstance();
        if ($method->getCode() == 'openpay') {
            $quote = Mage::getSingleton('checkout/session')->getQuote();
            $checkoutHelper = Mage::helper('openpay_payment/checkout');
            $total = floatval($quote->getGrandTotal());
            if ($total < floatval($this->_getHelper()->getMinPrice()) || $total > floatval($this->_getHelper()->getMaxPrice())) {
                $result = $observer->getResult();
                $result->isAvailable = false;
            } elseif ($quote->getIsMultiShipping() == 1) {
                $result = $observer->getResult();
                $result->isAvailable = false;
            } elseif ($checkoutHelper->isProductExcluded($quote) == true) {
                $result = $observer->getResult();
                $result->isAvailable = false;
            } elseif ($checkoutHelper->isCategoryExcluded($quote) == true) {
                $result = $observer->getResult();
                $result->isAvailable = false;
            }
        }
        
    }
    
    /**
     * get Min and Max values from Openpay API
     */
    public function getLimitsFromOpenpay($backendParams = null)
    {
        $response = [];
        try {
            $max = $this->_getHelper()->getMaxPrice();
            $min = $this->_getHelper()->getMinPrice();
            
            if (array_key_exists('auth_user', $backendParams) && array_key_exists('auth_token', $backendParams)) {
                $authUser = $backendParams['auth_user'];
                $authToken = $backendParams['auth_token'];
                $paymentMode = $backendParams['payment_mode'];
                $region = $backendParams['region'];
                Mage::getModel('core/config')->saveConfig(Openpay_Payment_Helper_Data::PATH_AUTH_USER, $authUser);
                Mage::getModel('core/config')->saveConfig(Openpay_Payment_Helper_Data::PATH_AUTH_KEY, $authToken); 
                Mage::getModel('core/config')->saveConfig(Openpay_Payment_Helper_Data::PATH_PAYMENT_MODE, $paymentMode);
                Mage::getModel('core/config')->saveConfig(Openpay_Payment_Helper_Data::PATH_REGION, $region);
            } else {
                $backendParams = null;
            }
            
            /** @var $paymentmanager \BusinessLayer\Openpay\PaymentManager */
            $paymentmanagert = $this->_getHelper()->getPaymentmanager($backendParams);
            $response = $paymentmanagert->getConfiguration();
            
            if (empty($response)) {
                throw new Exception('Response is empty');
            }
            
            $openpayMinPrice = ((int)$response->minPrice)/100;
            $openpayMaxPrice = ((int)$response->maxPrice)/100;
            
            if ($min != $openpayMinPrice) {
                $minField = Openpay_Payment_Helper_Data::PATH_MIN_PRICE;
                Mage::getModel('core/config')->saveConfig($minField, $openpayMinPrice);
            }
            if ($max != $openpayMaxPrice) {
                $maxField = Openpay_Payment_Helper_Data::PATH_MAX_PRICE;
                Mage::getModel('core/config')->saveConfig($maxField, $openpayMaxPrice);
            }
            Mage::getModel('core/config')->cleanCache();
            $response = ['min' => $openpayMinPrice, 'max' => $openpayMaxPrice];    
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
            Mage::Log($ex->getMessage(), null, 'openpaymagento.log', true);
        }
        
        return $response;
    }
    
    /**
     * order will be cancel when order is pending and from openpay
     * and their status will check from API
     */
    public function cancelPendingOrders()
    {
        $helper = $this->_getHelper();
        $checkoutHelper = Mage::helper('openpay_payment/checkout');
        $minutes = $helper->getFrequency() ? $helper->getFrequency() : 0;
        $collection = Mage::getModel('sales/order')->getCollection()
        ->addFieldToFilter(
            'status', 
            'pending'
        )
        ->addFieldToFilter(
            'created_at', 
                array('lt' => new Zend_Db_Expr(
                "DATE_SUB(
                    '" . Mage::getModel('core/date')->gmtDate() . "', INTERVAL " . $minutes . " MINUTE)"
                )
            )
        );
        $collection->getSelect()
        ->join(
            ["sop" => "sales_flat_order_payment"],
            'main_table.entity_id = sop.parent_id',
            array('method')
        )
        ->where('sop.method = ?','openpay'); 
        
        if ($collection->getSize() > 0) {
            /** @var $paymentmanager \BusinessLayer\Openpay\PaymentManager */
            $sdk = $helper->getPaymentmanager();
            foreach ($collection as $order) {
                if ($order->getToken() != null) {
                    try {
                        $sdk->setUrlAttributes(array($order->getToken()));
                        $response = $sdk->getOrder();
                    } catch(Exception $e) {
                        $message = $e->getMessage();
                        if (strpos($message, 'Error 12704') !== false) {
                            $order->cancel();
                            $order->save();
                        } else {
                            Mage::Log($ex->getMessage(), null, 'openpaymagento.log', true);
                        }
                    }
                    if ($response->orderStatus == 'Approved' && $response->planStatus == 'Active') {
                        //capture payment and generate invoice on magento
                        $checkoutHelper->generateInvoice($order);
                    } else {
                        $order->cancel();
                        $order->save();
                    } 
                }
            }
        }
    }

    /**
     * Execute shipment api call when we create shipment for the order
     * 
     * @param Varien_Event_Observer $observer
     */
    public function salesOrderShipmentSaveAfter(Varien_Event_Observer $observer)
    {
        $shipment = $observer->getEvent()->getShipment();
        $order = $shipment->getOrder();
        $method = $order->getPayment()->getMethod();
        if ($method == 'openpay') {
            try {
                $sdk = $this->_getHelper()->getPaymentmanager();
                $sdk->setUrlAttributes([$order->getToken()]);
                $response = $sdk->dispatch();
            } catch (Exception $e) {
                Mage::Log($e->getMessage(), null, 'openpaymagento.log', true);
            }
        }
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
