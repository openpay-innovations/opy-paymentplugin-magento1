<?php
/**
 * General Model file for Openpay.
 *
 * @category Openpay
 * @package  Openpay_Payment
 * @author   ideatarmac.com
 */

class Openpay_Payment_Model_Openpay extends Mage_Payment_Model_Method_Abstract
{
    protected $_canCapture = true;
    protected $_canRefund = true;
    protected $_canRefundInvoicePartial = true;
    protected $_code = 'openpay';
    protected $_formBlockType = 'openpay_payment/form_openpay';
    
    /**
     * Capture Payment
     * 
     * @param Varien_Object $payment
     * @param               $amount
     *
     * @return $this|Mage_Payment_Model_Abstract
     */
    public function capture(Varien_Object $payment, $amount) 
    {
        if (!$this->canCapture()) {
            return;
        }
        
        /** @var Mage_Sales_Model_Order $order */
        $order = $payment->getOrder();
        $ids = [$order->getToken()];
        $otherData = new stdClass();
        $otherData->orderid = $order->getIncrementId();
        
        try {
            /** @var $paymentmanager \BusinessLayer\Openpay\PaymentManager */
            $paymentmanager = $this->_getHelper()->getPaymentmanager();
            $paymentmanager->setUrlAttributes($ids);
            $paymentmanager->setShopdata(null, $otherData);
            $response = $paymentmanager->getCapture();
            $payment->setTransactionId($response->orderId);
	    $payment->setIsTransactionClosed(0);
        } catch (Exception $ex) {
            Mage::Log($ex->getMessage(), null, 'openpaymagento.log', true);
            Mage::throwException('There was some problem. Please contact us');
        }

        return $this;
    }
    
    /**
     * Refund specified amount for payment
     *
     * @param Varien_Object $payment
     * @param float         $amount
     * 
     * @return $this|Mage_Payment_Model_Abstract
     */
    public function refund(Varien_Object $payment, $amount)
    {
        if (!$this->canRefund()) {
            return;
        }
        
        /** @var Mage_Sales_Model_Order $order */
        $order = $payment->getOrder();
        $isFullRefund = false;
        $totalPaid = $order->getTotalPaid();
        $totalOnlineRefund = $order->getTotalOnlineRefunded();
        $remainingAmount = $totalPaid - $totalOnlineRefund;
        
        if (strval($remainingAmount) == $amount) {
            $isFullRefund = true;
        }
        $reduce = round((float)$amount, 2);
        $prices = [
            'newPrice' => 0,
            'reducePriceBy'=> (int)($reduce * 100), 
            'isFullRefund' => $isFullRefund
        ];  
        
        try {
            /** @var $paymentmanager \BusinessLayer\Openpay\PaymentManager */
            $paymentmanager = $this->_getHelper()->getPaymentmanager();
            $paymentmanager->setUrlAttributes(array($order->getToken()));
            $paymentmanager->setShopdata(null, $prices);
            $response = $paymentmanager->refund();
        } catch(Exception $ex) {
            $message = 'There is some problem in Openpay refund. Please contact us.';
            Mage::Log($ex->getMessage(), null, 'openpaymagento.log', true);
            Mage::throwException($message);
            
        }
        
        return $this;
    }
    
    /**
     * checks if openpay.js is loaded. If not it throws an excetion
     * 
     * @return $this|Mage_Payment_Model_Abstract
     */
    public function validate() 
    {
        $openpayJsLoaded = Mage::app()->getRequest()->getParam('openpayJsLoaded');
        if ($openpayJsLoaded) {
            Mage::throwException('An error occured while trying to checkout with Openpay. Please try again!');
        }
        
        return $this;
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
