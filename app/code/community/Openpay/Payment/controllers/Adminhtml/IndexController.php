<?php

class Openpay_Payment_Adminhtml_IndexController extends Mage_Adminhtml_Controller_Action 
{
    protected function _initOrder()
    {
        $id = $this->getRequest()->getParam('order_id');
        $order = Mage::getModel('sales/order')->load($id);

        if (!$order->getId()) {
            $this->_getSession()->addError($this->__('This order no longer exists.'));
            $this->_redirect('*/*/');
            $this->setFlag('', self::FLAG_NO_DISPATCH, true);
            return false;
        }
        Mage::register('sales_order', $order);
        Mage::register('current_order', $order);
        return $order;
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

    public function dispatchedAction()
    {
        if ($order = $this->_initOrder()) {
            try {
                try {
                    /** @var $paymentmanager \BusinessLayer\Openpay\PaymentManager */
                    $paymentmanager = $this->_getHelper()->getPaymentmanager();
                    $paymentmanager->setUrlAttributes([$order->getToken()]);
                    $response = $paymentmanager->dispatch();    
                    $this->_getSession()->addSuccess(
                        $this->__('Goods dispatched successfully from Openpay API.')
                    );         
                } catch(\Exception $e) {
                    Mage::Log($e->getMessage(), null, 'openpaymagento.log', true);
                    $this->_getSession()->addError('Sorry there is an error. Please contact us');
                }
            }
            catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
            catch (Exception $e) {
                $this->_getSession()->addError($this->__('Goods not dispatched due to some API Issue.'));
                Mage::logException($e);
            }
            $this->_redirect('adminhtml/sales_order/view', array('order_id' => $order->getId()));
        }
    }
}