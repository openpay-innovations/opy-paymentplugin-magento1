<?php
/**
 * It will executed after coming back from Openpay
 *
 * @category Openpay
 * @package  Openpay_Payment
 * @author   ideatarmac.com
 */

class Openpay_Payment_ResideController extends Mage_Core_Controller_Front_Action
{
    /**
     * Retrieve Openpay helper
     *
     * @return Openpay_Payment_Helper_Data
     */
    protected function _getHelper()
    {
        return Mage::helper('openpay_payment');
    }
    
    /**
     * after successful payment , it will capture the payment as well as invoice will
     * be generate and then redirect to success page of magento. If not, it will
     * redirect to cart page with some error message
     */
    public function resultAction()
    {
        $status = Mage::app()->getRequest()->getParam('status');
        $planid = Mage::app()->getRequest()->getParam('planid');
        $quoteid = Mage::app()->getRequest()->getParam('orderid');
        if ($status == "LODGED") {
            $session = Mage::getSingleton('checkout/session');
            $quote = $session->getQuote();
            if (!empty($quote->getGrandTotal())) {
            $purchasePrice = 0;

            try {
                /** @var $paymentmanager \BusinessLayer\Openpay\PaymentManager */
                $paymentmanager = $this->_getHelper()->getPaymentmanager();
                $paymentmanager->setUrlAttributes(array($planid));
                $response = $paymentmanager->getOrder();
                $purchasePrice = $response->purchasePrice;              
            } catch(\Exception $e) {
                Mage::Log($e->getMessage(), null, 'openpaymagento.log', true);
                $this->addErrorMessage('Sorry there is an error. Please contact us');
                $this->_redirect('checkout/cart');
            }
            $totalFromCart = round((float)$quote->getGrandTotal(), 2);
            if ((int)($totalFromCart * 100) == $purchasePrice) {
                $quote->collectTotals();
                try {
                    /** @var $service Mage_Sales_Model_Service_Quote */
                    $service = Mage::getModel('sales/service_quote', $quote);
                    $service->submitAll();
                    $quote->save();
                    /** @var  $order Mage_Sales_Model_Order */
                    $order = $service->getOrder();
                    $order->setToken($planid)->save();
                    $session->setLastQuoteId($quoteid)
                            ->setLastSuccessQuoteId($quoteid);
                    $session->setLastOrderId($order->getId())
                        ->setLastRealOrderId($order->getIncrementId());
                } catch(\Exception $e) {
                    Mage::logException($e);
                }
            } else {
                $this->addErrorMessage('Cart price is different to Openpay plan amount.');
                $this->_redirect('checkout/cart');
            }

            Mage::helper('openpay_payment/checkout')->generateInvoice($order);
            $this->_redirect('checkout/onepage/success');
            } else {
                $this->_redirect('checkout/cart');
            }
        } else {
            $this->addErrorMessage('Openpay Transaction was cancelled. Please try again.');
            $this->_redirect('checkout/cart');
        } 
    }
    
    /**
     * set Error message shown in frontend
     * 
     * @param string $message
     */
    private function addErrorMessage($message)
    {
        Mage::getSingleton('core/session')->addError($message);
    }
    
}
