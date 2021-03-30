<?php
/**
 * Openpay Checkout Controller
 *
 * @category Openpay
 * @package  Openpay_Payment
 * @author   ideatarmac.com
 */

class Openpay_Payment_TokenizationController extends Mage_Core_Controller_Front_Action
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
     * creates token and redirect to openpay page after clicking place order button
     */
    public function gatewayAction() 
    {
        $session = Mage::getSingleton('checkout/session');
        $quote = $session->getQuote();
        if (!$quote->getCustomerEmail()) {
            $quote->setCheckoutMethod('guest')
            ->setCustomerId(null)
            ->setCustomerEmail($quote->getBillingAddress()->getEmail())
            ->setCustomerIsGuest(true)
            ->setCustomerGroupId(Mage_Customer_Model_Group::NOT_LOGGED_IN_ID);
            $quote->save();
        }
        $backofficeparams = $this->_getHelper()->getBackendParams();
        
        $otherData = new stdClass();
        $otherData->origin = "Online";
        $otherData->planCreationType = "pending";
        $otherData->merchantRedirectUrl = Mage::getUrl("openpay/reside/result");
        
        try {
            /** @var $paymentmanager \BusinessLayer\Openpay\PaymentManager */
            $paymentmanager = $this->_getHelper()->getPaymentmanager();
            $paymentmanager->setShopdata($quote, $otherData);
            $token = $paymentmanager->getToken();
            
            $paymentmanager->setShopdata(null, null, $token, null, $backofficeparams);
            $paymentPage = $paymentmanager->getPaymentPage('redirect', false, 'GET');
            
            $block = $this->getLayout()->createBlock(
                    'Mage_Core_Block_Template','openpay',
                    array('template' => 'openpay/submitOpenpay.phtml',
                          'paymentPage' => $paymentPage,
                          'dir' => (__DIR__)
                        ))->toHtml();
            $this->getResponse()->setBody($block);
        } catch (Exception $ex) {
            Mage::Log($ex->getMessage(), null, 'openpaymagento.log', true);
            Mage::getSingleton('core/session')->addError('There is some problem on payment method. Please contact us or select another payment method.');
            $this->_redirect('checkout/onepage');
        }        
        
    }
    
    /**
     * redirect to Review page
     */
    public function redirectAction()
    {
        $this->loadLayout();
        $block = $this->getLayout()->createBlock('Mage_Core_Block_Template','openpay',array('template' => 'openpay/redirect.phtml'));
        $this->getLayout()->getBlock('content')->append($block);
        $this->renderLayout();
    }
}
